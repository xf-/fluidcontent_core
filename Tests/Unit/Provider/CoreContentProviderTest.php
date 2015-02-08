<?php
namespace FluidTYPO3\FluidcontentCore\Tests\Unit\Provider;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\FluidcontentCore\Provider\CoreContentProvider;
use FluidTYPO3\Flux\Form;
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

	/**
	 * @dataProvider getFormTestValues
	 * @param array $record
	 */
	public function testGetForm(array $record) {
		$instance = $this->getMock(
			'FluidTYPO3\\FluidcontentCore\\Provider\\CoreContentProvider',
			array('resolveFormClassName', 'setDefaultValuesInFieldsWithInheritedValues')
		);
		$form = Form::create();
		$instance->setForm($form);
		$result = $instance->getForm($record);
		$this->assertInstanceOf('FluidTYPO3\\Flux\\Form', $result);
	}

	/**
	 * @return array
	 */
	public function getFormTestValues() {
		return array(
			array(array()),
			array(array(CoreContentProvider::CTYPE_FIELDNAME => CoreContentProvider::CTYPE_MENU)),
			array(array(CoreContentProvider::CTYPE_FIELDNAME => CoreContentProvider::CTYPE_TABLE))
		);
	}

}
