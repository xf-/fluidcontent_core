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

	/**
	 * @dataProvider getExtensionKeyTestValues
	 * @param array $row
	 * @param string|NULL $expected
	 */
	public function testGetExtensionKey(array $row, $expected) {
		$instance = new CoreContentProvider();
		$result = $instance->getExtensionKey($row);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @dataProvider getExtensionKeyTestValues
	 * @param array $row
	 * @param string|NULL $expected
	 */
	public function testGetControllerExtensionKeyFromRecord(array $row, $expected) {
		$instance = new CoreContentProvider();
		$result = $instance->getControllerExtensionKeyFromRecord($row);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @return array
	 */
	public function getExtensionKeyTestValues() {
		return array(
			array(array(), 'fluidcontent_core'),
			array(array('content_variant' => 'test'), 'test'),
			array(array('content_variant' => 'Vendor.Test'), 'test')
		);
	}

	/**
	 * @dataProvider getVariantVersionTestValues
	 * @param array $row
	 * @param string $expected
	 */
	public function testGetVariant(array $row, $expected) {
		$defaults = array('version' => 'version', 'variant' => 'variant');
		$instance = $this->getMock('FluidTYPO3\\FluidcontentCore\\Provider\\CoreContentProvider', array('getDefaults'));
		$instance->expects($this->once())->method('getDefaults')->willReturn($defaults);
		$result = $this->callInaccessibleMethod($instance, 'getVariant', $row);
		$this->assertEquals(NULL === $expected ? $defaults['variant'] : $expected, $result);
	}

	/**
	 * @dataProvider getVariantVersionTestValues
	 * @param array $row
	 * @param string $expected
	 */
	public function testGetVersion(array $row, $expected) {
		$defaults = array('version' => 'version', 'variant' => 'variant');
		$instance = $this->getMock('FluidTYPO3\\FluidcontentCore\\Provider\\CoreContentProvider', array('getDefaults'));
		$instance->expects($this->once())->method('getDefaults')->willReturn($defaults);
		$result = $this->callInaccessibleMethod($instance, 'getVersion', $row);
		$this->assertEquals(NULL === $expected ? $defaults['version'] : $expected, $result);
	}

	/**
	 * @return array
	 */
	public function getVariantVersionTestValues() {
		return array(
			array(array(), NULL),
			array(array('content_version' => '1', 'content_variant' => '1'), '1'),
		);
	}

	/**
	 * @dataProvider getControllerActionFromRecordTestValues
	 * @param array $row
	 * @param string|NULL $expected
	 */
	public function testGetControllerActionFromRecord(array $row, $expected) {
		$instance = new CoreContentProvider();
		$result = $instance->getControllerActionFromRecord($row);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @return array
	 */
	public function getControllerActionFromRecordTestValues() {
		return array(
			array(array(), NULL),
			array(array('CType' => 'test'), 'test'),
			array(array('CType' => 'Test'), 'test'),
			array(array('CType' => 'CamelCase'), 'camelcase'),
			array(array('CType' => 'under_scored'), 'under_scored'),
		);
	}

}
