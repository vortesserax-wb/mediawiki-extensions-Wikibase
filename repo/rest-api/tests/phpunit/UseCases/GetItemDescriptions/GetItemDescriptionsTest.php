<?php declare( strict_types = 1 );

namespace Wikibase\Repo\Tests\RestApi\UseCases\GetItemDescriptions;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wikibase\DataModel\Entity\ItemId;
use Wikibase\Repo\RestApi\Domain\Model\LatestItemRevisionMetadataResult;
use Wikibase\Repo\RestApi\Domain\ReadModel\Description;
use Wikibase\Repo\RestApi\Domain\ReadModel\Descriptions;
use Wikibase\Repo\RestApi\Domain\Services\ItemDescriptionsRetriever;
use Wikibase\Repo\RestApi\Domain\Services\ItemRevisionMetadataRetriever;
use Wikibase\Repo\RestApi\UseCases\ErrorResponse;
use Wikibase\Repo\RestApi\UseCases\GetItemDescriptions\GetItemDescriptions;
use Wikibase\Repo\RestApi\UseCases\GetItemDescriptions\GetItemDescriptionsRequest;
use Wikibase\Repo\RestApi\UseCases\GetItemDescriptions\GetItemDescriptionsSuccessResponse;
use Wikibase\Repo\RestApi\UseCases\GetItemDescriptions\GetItemDescriptionsValidator;
use Wikibase\Repo\RestApi\UseCases\UseCaseException;
use Wikibase\Repo\RestApi\Validation\ItemIdValidator;

/**
 * @covers \Wikibase\Repo\RestApi\UseCases\GetItemDescriptions\GetItemDescriptions
 *
 * @group Wikibase
 *
 * @license GPL-2.0-or-later
 */
class GetItemDescriptionsTest extends TestCase {

	/**
	 * @var MockObject|ItemRevisionMetadataRetriever
	 */
	private $itemRevisionMetadataRetriever;

	/**
	 * @var MockObject|ItemDescriptionsRetriever
	 */
	private $descriptionsRetriever;

	protected function setUp(): void {
		parent::setUp();

		$this->itemRevisionMetadataRetriever = $this->createStub( ItemRevisionMetadataRetriever::class );
		$this->descriptionsRetriever = $this->createStub( ItemDescriptionsRetriever::class );
	}

	public function testSuccess(): void {
		$descriptions = new Descriptions(
			new Description( 'en', 'third planet from the Sun in the Solar System' ),
			new Description( 'ar', 'الكوكب الثالث في المجموعة الشمسية' ),
		);

		$itemId = new ItemId( 'Q2' );
		$lastModified = '20201111070707';
		$revisionId = 2;

		$this->itemRevisionMetadataRetriever = $this->createMock( ItemRevisionMetadataRetriever::class );
		$this->itemRevisionMetadataRetriever->expects( $this->once() )
			->method( 'getLatestRevisionMetadata' )
			->with( $itemId )
			->willReturn( LatestItemRevisionMetadataResult::concreteRevision( $revisionId, $lastModified ) );

		$this->descriptionsRetriever = $this->createMock( ItemDescriptionsRetriever::class );
		$this->descriptionsRetriever->expects( $this->once() )
			->method( 'getDescriptions' )
			->with( $itemId )
			->willReturn( $descriptions );

		$request = new GetItemDescriptionsRequest( 'Q2' );
		$response = $this->newUseCase()->execute( $request );
		$this->assertEquals( new GetItemDescriptionsSuccessResponse( $descriptions, $lastModified, $revisionId ), $response );
	}

	public function testGivenInvalidItemId_throws(): void {
		try {
			$this->newUseCase()->execute( new GetItemDescriptionsRequest( 'X321' ) );

			$this->fail( 'this should not be reached' );
		} catch ( UseCaseException $useCaseEx ) {
			$this->assertSame( ErrorResponse::INVALID_ITEM_ID, $useCaseEx->getErrorCode() );
			$this->assertSame( 'Not a valid item ID: X321', $useCaseEx->getErrorMessage() );
			$this->assertNull( $useCaseEx->getErrorContext() );
		}
	}

	private function newUseCase(): GetItemDescriptions {
		return new GetItemDescriptions(
			$this->itemRevisionMetadataRetriever,
			$this->descriptionsRetriever,
			new GetItemDescriptionsValidator( new ItemIdValidator() )
		);
	}

}
