<?php

namespace Wikibase\Client\Tests\Integration;

use MediaWiki\Title\Title;
use MediaWikiIntegrationTestCase;
use Wikibase\Client\ChangeNotificationJob;

/**
 * @covers \Wikibase\Client\ChangeNotificationJob
 *
 * @group Wikibase
 * @group WikibaseChange
 *
 * @license GPL-2.0-or-later
 * @author Daniel Kinzler
 * @author Marius Hoch
 */
class ChangeNotificationJobTest extends MediaWikiIntegrationTestCase {

	public static function provideToString() {
		return [
			'empty' => [
				[],
				'/^ChangeNotification.*/',
			],
			'some changes' => [
				[ 5, 37 ],
				'/^ChangeNotification/',
			],
		];
	}

	/**
	 * @dataProvider provideToString
	 */
	public function testToString( array $changeIds, $regex ) {
		$job = new ChangeNotificationJob(
			Title::newMainPage(),
			[ 'changeIds' => $changeIds ]
		);

		// toString used to fail on some platforms if a job contained a non-primitive parameter.
		$s = $job->toString();
		$this->assertMatchesRegularExpression( $regex, $s );
	}

	// TODO: testNewFromChanges
	// TODO: testGetChanges
	// TODO: testRun

}
