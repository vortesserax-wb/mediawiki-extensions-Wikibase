<?php

declare( strict_types = 1 );

namespace Wikibase\Repo\Tests\Unit\ServiceWiring;

use Wikibase\Lib\EntityTypeDefinitions;
use Wikibase\Repo\Tests\Unit\ServiceWiringTestCase;

/**
 * @coversNothing
 *
 * @group Wikibase
 *
 * @license GPL-2.0-or-later
 */
class SubEntityTypesMapperTest extends ServiceWiringTestCase {

	public function testConstruction() {
		$this->mockService(
			'WikibaseRepo.EntityTypeDefinitions',
			new EntityTypeDefinitions( [
				'lexeme' => [
					EntityTypeDefinitions::SUB_ENTITY_TYPES => [
						'form',
						'sense',
					],
				],
				'item' => [],
			] )
		);

		$this->assertSame(
			'lexeme',
			$this->getService( 'WikibaseRepo.SubEntityTypesMapper' )->getParentEntityType( 'form' )
		);
	}

}
