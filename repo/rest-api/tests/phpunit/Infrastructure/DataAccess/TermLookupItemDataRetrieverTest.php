<?php declare( strict_types=1 );

namespace Wikibase\Repo\Tests\RestApi\Infrastructure\DataAccess;

use PHPUnit\Framework\TestCase;
use Wikibase\DataModel\Entity\ItemId;
use Wikibase\DataModel\Services\Lookup\TermLookup;
use Wikibase\DataModel\Services\Lookup\TermLookupException;
use Wikibase\Lib\StaticContentLanguages;
use Wikibase\Repo\RestApi\Domain\ReadModel\Description;
use Wikibase\Repo\RestApi\Domain\ReadModel\Descriptions;
use Wikibase\Repo\RestApi\Domain\ReadModel\Label;
use Wikibase\Repo\RestApi\Domain\ReadModel\Labels;
use Wikibase\Repo\RestApi\Infrastructure\DataAccess\TermLookupItemDataRetriever;

/**
 * @covers \Wikibase\Repo\RestApi\Infrastructure\DataAccess\TermLookupItemDataRetriever
 *
 * @group Wikibase
 *
 * @license GPL-2.0-or-later
 */
class TermLookupItemDataRetrieverTest extends TestCase {

	private const ALL_TERM_LANGUAGES = [ 'de', 'en', 'ko' ];
	private const ITEM_ID = 'Q123';

	public function testGetLabels(): void {
		$itemId = new ItemId( self::ITEM_ID );

		$termLookup = $this->createMock( TermLookup::class );
		$termLookup->expects( $this->once() )
			->method( 'getLabels' )
			->with( $itemId, self::ALL_TERM_LANGUAGES )
			->willReturn( [
				'en' => 'potato',
				'de' => 'Kartoffel',
				'ko' => '감자',
			] );

		$this->assertEquals(
			( $this->newTermRetriever( $termLookup ) )->getLabels( $itemId ),
			new Labels(
				new Label( 'en', 'potato' ),
				new Label( 'de', 'Kartoffel' ),
				new Label( 'ko', '감자' ),
			)
		);
	}

	public function testLabelsLookupThrowsLookupException_returnsNull(): void {
		$itemId = new ItemId( self::ITEM_ID );

		$termLookup = $this->createStub( TermLookup::class );
		$termLookup->method( 'getLabels' )
			->willThrowException( new TermLookupException( $itemId, [] ) );

		$this->assertNull( $this->newTermRetriever( $termLookup )->getLabels( $itemId ) );
	}

	public function testGetLabel(): void {
		$itemId = new ItemId( self::ITEM_ID );
		$languageCode = 'en';

		$termLookup = $this->createMock( TermLookup::class );
		$termLookup->expects( $this->once() )
			->method( 'getLabel' )
			->with( $itemId, $languageCode )
			->willReturn( 'potato' );

		$this->assertEquals(
			( $this->newTermRetriever( $termLookup ) )->getLabel( $itemId, $languageCode ),
			new Label( $languageCode, 'potato' )
		);
	}

	public function testGivenNoLabelInRequestedLanguage_getLabelReturnsNull(): void {
		$this->assertNull(
			( $this->newTermRetriever( $this->createStub( TermLookup::class ) ) )
				->getLabel( new ItemId( 'Q321' ), 'ko' )
		);
	}

	public function testGetDescriptions(): void {
		$itemId = new ItemId( self::ITEM_ID );

		$termLookup = $this->createMock( TermLookup::class );
		$termLookup->expects( $this->once() )
			->method( 'getDescriptions' )
			->with( $itemId, self::ALL_TERM_LANGUAGES )
			->willReturn( [
				'en' => 'English science fiction writer and humourist',
				'de' => 'britischer Science-Fiction-Autor und Humorist (1952–2001)',
				'ko' => '영국의 작가',
			] );

		$this->assertEquals(
			( $this->newTermRetriever( $termLookup ) )->getDescriptions( $itemId ),
			new Descriptions(
				new Description( 'en', 'English science fiction writer and humourist' ),
				new Description( 'de', 'britischer Science-Fiction-Autor und Humorist (1952–2001)' ),
				new Description( 'ko', '영국의 작가' ),
			)
		);
	}

	public function testDescriptionsLookupThrowsLookupException_returnsNull(): void {
		$itemId = new ItemId( self::ITEM_ID );

		$termLookup = $this->createStub( TermLookup::class );
		$termLookup->method( 'getDescriptions' )
			->willThrowException( new TermLookupException( $itemId, [] ) );

		$this->assertNull( $this->newTermRetriever( $termLookup )->getDescriptions( $itemId ) );
	}

	private function newTermRetriever( TermLookup $termLookup ): TermLookupItemDataRetriever {
		return new TermLookupItemDataRetriever(
			$termLookup,
			new StaticContentLanguages( self::ALL_TERM_LANGUAGES )
		);
	}

	public function testGetDescription(): void {
		$itemId = new ItemId( self::ITEM_ID );

		$termLookup = $this->createMock( TermLookup::class );
		$termLookup->expects( $this->once() )
			->method( 'getDescription' )
			->with( $itemId, 'en' )
			->willReturn( 'English science fiction writer and humourist' );

		$this->assertEquals(
			( $this->newTermRetriever( $termLookup ) )->getDescription( $itemId, 'en' ),
			new Description( 'en', 'English science fiction writer and humourist' ),
		);
	}

	public function testGivenNoDescriptionInRequestedLanguage_getDescriptionReturnsNull(): void {
		$this->assertNull(
			( $this->newTermRetriever( $this->createStub( TermLookup::class ) ) )
				->getDescription( new ItemId( 'Q321' ), 'ko' )
		);
	}
}