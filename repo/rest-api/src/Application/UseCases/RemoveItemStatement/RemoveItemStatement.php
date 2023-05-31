<?php declare( strict_types=1 );

namespace Wikibase\Repo\RestApi\Application\UseCases\RemoveItemStatement;

use Wikibase\DataModel\Entity\ItemId;
use Wikibase\DataModel\Services\Statement\StatementGuidParser;
use Wikibase\Repo\RestApi\Application\UseCases\UseCaseError;
use Wikibase\Repo\RestApi\Domain\Model\EditMetadata;
use Wikibase\Repo\RestApi\Domain\Model\StatementEditSummary;
use Wikibase\Repo\RestApi\Domain\Model\User;
use Wikibase\Repo\RestApi\Domain\Services\ItemRetriever;
use Wikibase\Repo\RestApi\Domain\Services\ItemRevisionMetadataRetriever;
use Wikibase\Repo\RestApi\Domain\Services\ItemUpdater;
use Wikibase\Repo\RestApi\Domain\Services\PermissionChecker;

/**
 * @license GPL-2.0-or-later
 */
class RemoveItemStatement {

	private RemoveItemStatementValidator $validator;
	private ItemRevisionMetadataRetriever $revisionMetadataRetriever;
	private StatementGuidParser $statementIdParser;
	private ItemRetriever $itemRetriever;
	private ItemUpdater $itemUpdater;
	private PermissionChecker $permissionChecker;

	public function __construct(
		RemoveItemStatementValidator $validator,
		ItemRevisionMetadataRetriever $revisionMetadataRetriever,
		StatementGuidParser $statementGuidParser,
		ItemRetriever $itemRetriever,
		ItemUpdater $itemUpdater,
		PermissionChecker $permissionChecker
	) {
		$this->validator = $validator;
		$this->revisionMetadataRetriever = $revisionMetadataRetriever;
		$this->statementIdParser = $statementGuidParser;
		$this->itemRetriever = $itemRetriever;
		$this->itemUpdater = $itemUpdater;
		$this->permissionChecker = $permissionChecker;
	}

	/**
	 * @throws UseCaseError
	 */
	public function execute( RemoveItemStatementRequest $request ): void {
		$this->validator->assertValidRequest( $request );

		$statementId = $this->statementIdParser->parse( $request->getStatementId() );
		$requestedItemId = $request->getItemId();
		/** @var ItemId $itemId */
		$itemId = $requestedItemId ? new ItemId( $requestedItemId ) : $statementId->getEntityId();
		'@phan-var ItemId $itemId';

		$revisionMetadata = $this->revisionMetadataRetriever->getLatestRevisionMetadata( $itemId );
		if ( $requestedItemId && !$revisionMetadata->itemExists() ) {
			throw new UseCaseError(
				UseCaseError::ITEM_NOT_FOUND,
				"Could not find an item with the ID: {$itemId}"
			);
		} elseif ( !$revisionMetadata->itemExists()
				   || $revisionMetadata->isRedirect()
				   || !$itemId->equals( $statementId->getEntityId() )
		) {
			$this->throwStatementNotFoundException( $request->getStatementId() );
		}

		// @phan-suppress-next-line PhanTypeMismatchArgumentNullable hasUser checks for null
		$user = $request->hasUser() ? User::withUsername( $request->getUsername() ) : User::newAnonymous();
		if ( !$this->permissionChecker->canEdit( $user, $itemId ) ) {
			throw new UseCaseError(
				UseCaseError::PERMISSION_DENIED,
				'You have no permission to edit this item.'
			);
		}

		$item = $this->itemRetriever->getItem( $itemId );
		$statement = $item->getStatements()->getFirstStatementWithGuid( $request->getStatementId() );
		if ( !$statement ) {
			$this->throwStatementNotFoundException( $request->getStatementId() );
		}

		$item->getStatements()->removeStatementsWithGuid( (string)$statementId );

		$editMetadata = new EditMetadata(
			$request->getEditTags(),
			$request->isBot(),
			StatementEditSummary::newRemoveSummary( $request->getComment(), $statement )
		);
		// @phan-suppress-next-line PhanTypeMismatchArgumentNullable Item validated and exists
		$this->itemUpdater->update( $item, $editMetadata );
	}

	/**
	 * @return never
	 * @throws UseCaseError
	 */
	private function throwStatementNotFoundException( string $statementId ): void {
		throw new UseCaseError(
			UseCaseError::STATEMENT_NOT_FOUND,
			"Could not find a statement with the ID: $statementId"
		);
	}
}