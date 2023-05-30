<?php

declare( strict_types = 1 );

namespace Wikibase\Lib\Store\Sql;

use Wikibase\DataModel\Entity\EntityId;
use Wikimedia\Rdbms\IReadableDatabase;

/**
 * Interface to run a query to find an entity of given ID within the mediawiki page table
 * and also map resulting rows back to the entity IDs they relate to.
 *
 * @license GPL-2.0-or-later
 */
interface PageTableEntityQuery {

	/**
	 * @param array $fields Fields to select
	 * @param array $joins Joins to use, Keys must be table names.
	 * @param EntityId[] $entityIds EntityIds to select
	 * @param IReadableDatabase $db DB to query on
	 * @return \stdClass[] Array of rows with keys of their entity ID serializations
	 */
	public function selectRows(
		array $fields,
		array $joins,
		array $entityIds,
		IReadableDatabase $db
	);

}
