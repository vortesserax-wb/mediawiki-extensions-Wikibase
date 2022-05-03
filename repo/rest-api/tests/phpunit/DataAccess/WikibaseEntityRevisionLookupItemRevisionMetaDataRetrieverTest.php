<?php declare( strict_types=1 );

namespace Wikibase\Repo\Tests\RestApi\UseCases\GetItem;

use PHPUnit\Framework\TestCase;
use Wikibase\DataModel\Entity\ItemId;
use Wikibase\Lib\Store\EntityRevisionLookup;
use Wikibase\Lib\Store\LatestRevisionIdResult;
use Wikibase\Repo\RestApi\DataAccess\WikibaseEntityRevisionLookupItemRevisionMetaDataRetriever;

/**
 * @covers \Wikibase\Repo\RestApi\DataAccess\WikibaseEntityRevisionLookupItemRevisionMetaDataRetriever
 *
 * @group Wikibase
 *
 * @license GPL-2.0-or-later
 */
class WikibaseEntityRevisionLookupItemRevisionMetaDataRetrieverTest extends TestCase {

	public function testGivenConcreteRevision_getLatestRevisionMetaDataReturnsMetaData(): void {
		$item = new ItemId( 'Q1234' );
		$expectedRevisionId = 777;
		$expectedRevisionTimestamp = '20201111070707';
		$entityRevisionLookup = $this->createMock( EntityRevisionLookup::class );
		$entityRevisionLookup->expects( $this->once() )
			->method( 'getLatestRevisionId' )
			->with( $item )
			->willReturn( LatestRevisionIdResult::concreteRevision( $expectedRevisionId, $expectedRevisionTimestamp ) );

		$metaDataRetriever = new WikibaseEntityRevisionLookupItemRevisionMetaDataRetriever( $entityRevisionLookup );
		$result = $metaDataRetriever->getLatestRevisionMetaData( $item );

		$this->assertSame( $expectedRevisionId, $result->getRevisionId() );
		$this->assertSame( $expectedRevisionTimestamp, $result->getRevisionTimestamp() );
	}

	public function testGivenRedirect_getLatestRevisionMetaDataReturnsRedirectResult(): void {
		$itemWithRedirect = new ItemId( 'Q4321' );
		$redirectTarget = new ItemId( 'Q1234' );
		$entityRevisionLookup = $this->createMock( EntityRevisionLookup::class );
		$entityRevisionLookup->expects( $this->once() )
			->method( 'getLatestRevisionId' )
			->with( $itemWithRedirect )
			->willReturn( LatestRevisionIdResult::redirect( 9876, $redirectTarget ) );

		$metaDataRetriever = new WikibaseEntityRevisionLookupItemRevisionMetaDataRetriever( $entityRevisionLookup );
		$result = $metaDataRetriever->getLatestRevisionMetaData( $itemWithRedirect );

		$this->assertTrue( $result->isRedirect() );
		$this->assertSame( $redirectTarget, $result->getRedirectTarget() );
	}

	public function testGivenItemDoesNotExist_getLatestRevisionMetaDataReturnsItemNotFoundResult(): void {
		$nonexistentItem = new ItemId( 'Q666' );
		$entityRevisionLookup = $this->createMock( EntityRevisionLookup::class );
		$entityRevisionLookup->expects( $this->once() )
			->method( 'getLatestRevisionId' )
			->with( $nonexistentItem )
			->willReturn( LatestRevisionIdResult::nonexistentEntity() );

		$metaDataRetriever = new WikibaseEntityRevisionLookupItemRevisionMetaDataRetriever( $entityRevisionLookup );
		$result = $metaDataRetriever->getLatestRevisionMetaData( $nonexistentItem );

		$this->assertFalse( $result->itemExists() );
	}

}
