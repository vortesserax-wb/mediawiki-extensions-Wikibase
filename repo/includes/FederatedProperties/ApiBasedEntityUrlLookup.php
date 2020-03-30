<?php

namespace Wikibase\Repo\FederatedProperties;

use Wikibase\DataModel\Entity\EntityId;
use Wikibase\Lib\Store\EntityUrlLookup;

/**
 * @license GPL-2.0-or-later
 */
class ApiBasedEntityUrlLookup implements EntityUrlLookup {

	/**
	 * @var ApiBasedEntityTitleTextLookup
	 */
	private $titleTextLookup;

	/**
	 * @var string
	 */
	private $sourceWikibaseUrl;

	public function __construct( ApiBasedEntityTitleTextLookup $titleTextLookup, string $sourceWikibaseUrl ) {
		$this->titleTextLookup = $titleTextLookup;
		$this->sourceWikibaseUrl = $sourceWikibaseUrl;
	}

	public function getFullUrl( EntityId $id ): ?string {
		$titleText = $this->titleTextLookup->getPrefixedText( $id );

		if ( $titleText === null ) {
			return null;
		}

		return $this->sourceWikibaseUrl . 'index.php?' . http_build_query( [
				'title' => $titleText,
			] );
	}

}
