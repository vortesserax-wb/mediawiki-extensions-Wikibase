<?php declare( strict_types = 1 );

namespace Wikibase\Repo\Tests\RestApi\Application\UseCases\SetItemDescription;

use Wikibase\DataModel\Entity\Item as DataModelItem;
use Wikibase\Repo\RestApi\Application\UseCases\SetItemDescription\SetItemDescription;
use Wikibase\Repo\RestApi\Application\UseCases\SetItemDescription\SetItemDescriptionRequest;
use Wikibase\Repo\RestApi\Domain\ReadModel\Description;
use Wikibase\Repo\RestApi\Domain\ReadModel\Descriptions;
use Wikibase\Repo\RestApi\Domain\ReadModel\Item as ReadModelItem;
use Wikibase\Repo\RestApi\Domain\ReadModel\ItemRevision;
use Wikibase\Repo\RestApi\Domain\ReadModel\Labels;
use Wikibase\Repo\RestApi\Domain\ReadModel\StatementList;
use Wikibase\Repo\RestApi\Domain\Services\ItemRetriever;
use Wikibase\Repo\RestApi\Domain\Services\ItemUpdater;

/**
 * @covers \Wikibase\Repo\RestApi\Application\UseCases\SetItemDescription\SetItemDescription
 *
 * @group Wikibase
 *
 * @license GPL-2.0-or-later
 */
class SetItemDescriptionTest extends \PHPUnit\Framework\TestCase {

	public function testExecute_happyPath(): void {
		$language = 'en';
		$description = 'Hello world again.';
		$itemId = 'Q123';
		$item = new DataModelItem();

		$itemRetriever = $this->createStub( ItemRetriever::class );
		$itemRetriever->method( 'getItem' )->willReturn( $item );

		$updatedItem = new ReadModelItem(
			new Labels(),
			new Descriptions( new Description( $language, $description ) ),
			new StatementList()
		);
		$revisionId = 123;
		$lastModified = '20221212040506';

		$itemUpdater = $this->createMock( ItemUpdater::class );
		$itemUpdater->expects( $this->once() )
			->method( 'update' )
			->with( $this->callback(
				fn( DataModelItem $item ) => $item->getDescriptions()->toTextArray() === [ $language => $description ]
			) )
			->willReturn( new ItemRevision( $updatedItem, $lastModified, $revisionId ) );

		$useCase = new SetItemDescription( $itemRetriever, $itemUpdater );
		$response = $useCase->execute( new SetItemDescriptionRequest( $itemId, $language, $description ) );

		$this->assertEquals( new Description( $language, $description ), $response->getDescription() );
		$this->assertSame( $revisionId, $response->getRevisionId() );
		$this->assertSame( $lastModified, $response->getLastModified() );
	}
}
