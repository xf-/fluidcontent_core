<?php
namespace FluidTYPO3\FluidcontentCore\Tests\Unit\Provider;
/*****************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Claus Due <claus@namelesscoder.net>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *****************************************************************/

use FluidTYPO3\FluidcontentCore\Provider\CoreContentProvider;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class CoreContentProviderTest
 */
class CoreContentProviderTest extends UnitTestCase {

	/**
	 * @param array $row
	 * @param string $table
	 * @param string $field
	 * @param boolean $expected
	 * @test
	 * @dataProvider getTriggerTestValues
	 */
	public function testTrigger(array $row, $table, $field, $expected) {
		$instance = new CoreContentProvider();
		$result = $instance->trigger($row, $table, $field);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @return array
	 */
	public function getTriggerTestValues() {
		return array(
			array(array(), 'tt_content', 'content_options', TRUE),
			array(array(), 'tt_content', NULL, TRUE),
			array(array(), 'tt_content', 'pi_flexform', FALSE),
		);
	}

}
