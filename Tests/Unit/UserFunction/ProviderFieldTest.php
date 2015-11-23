<?php
namespace FluidTYPO3\FluidcontentCore\Tests\Unit\UserFunction;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\FluidcontentCore\Provider\CoreContentProvider;
use FluidTYPO3\FluidcontentCore\Tests\Fixtures\Service\AccessibleConfigurationService;
use FluidTYPO3\FluidcontentCore\UserFunction\ProviderField;
use TYPO3\CMS\Core\Tests\BaseTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ProviderFieldTest
 */
class ProviderFieldTest extends BaseTestCase {

	/**
	 * @dataProvider getCreateVariantsFieldTestValues
	 * @param array $variants
	 * @param array $defaults
	 * @param array $parameters
	 * @param array $mustContain
	 */
	public function testCreateVariantsField(array $variants, array $defaults, array $parameters, array $mustContain) {
		$service = new AccessibleConfigurationService();
		$service->setVariants($variants);
		$service->setDefaults($defaults);
		$instance = $this->getMock('FluidTYPO3\\FluidcontentCore\\UserFunction\\ProviderField', array('loadRecord', 'translateLabel'), array(), '', FALSE);
		$instance->expects($this->once())->method('loadRecord')->willReturn($parameters['row']);
		$instance->expects($this->atLeastOnce())->method('translateLabel')->willReturnArgument(0);
		$instance->injectConfigurationService($service);
		$result = $instance->createVariantsField($parameters);
		foreach ($mustContain as $requiredContent) {
			$this->assertContains($requiredContent, $result);
		}
	}

	/**
	 * @return array
	 */
	public function getCreateVariantsFieldTestValues() {
		return array(
			array(array(), array(), array(), array('<select', '<option selected="selected" value="">tt_content.nativeLabel</option>')),
			array(
				array('test' => array(array('fluidcontent_core', 'label', 'icon'))),
				array(),
				array('row' => array('CType' => 'not-test')),
				array('<select', '<option')
			),
			array(
				array('test' => array('fluidcontent_core' => array('fluidcontent_core', 'label', 'icon'))),
				array('mode' => CoreContentProvider::MODE_PRESELECT, 'variant' => 'fluidcontent_core'),
				array('row' => array('CType' => 'test')),
				array('<select', '<option', 'value="fluidcontent_core"')
			),
			array(
				array('test' => array(array('fluidcontent_core', 'label', 'icon'))),
				array(),
				array('row' => array('CType' => 'test', 'content_variant' => 'test')),
				array('<select', '<option', 'value="fluidcontent_core"')
			),
			array(
				array('test' => array(array('fluidcontent_core', 'label', 'icon'))),
				array(),
				array('row' => array('CType' => 'test', 'content_variant' => 'invalid')),
				array('<select', '<option', 'INVALID: ')
			),
		);
	}

	/**
	 * @dataProvider getCreateVersionsFieldTestValues
	 * @param array $variants
	 * @param array $versions
	 * @param array $defaults
	 * @param array $parameters
	 * @param array $mustContain
	 */
	public function testCreateVersionsField(array $variants, array $versions, array $defaults, array $parameters, array $mustContain) {
		$service = new AccessibleConfigurationService();
		$service->setVariants($variants);
		$service->setVersions($versions);
		$service->setDefaults($defaults);
		$instance = $this->getMock('FluidTYPO3\\FluidcontentCore\\UserFunction\\ProviderField', array('loadRecord', 'translateLabel'), array(), '', FALSE);
		$instance->expects($this->once())->method('loadRecord')->willReturn($parameters['row']);
		$instance->expects($this->atLeastOnce())->method('translateLabel')->willReturnArgument(0);
		$instance->injectConfigurationService($service);
		$result = $instance->createVersionsField($parameters);
		foreach ($mustContain as $requiredContent) {
			$this->assertContains($requiredContent, $result);
		}
	}

	/**
	 * @return array
	 */
	public function getCreateVersionsFieldTestValues() {
		return array(
			array(array(), array(), array(), array(), array('<select', '<option selected="selected" value="">tt_content.nativeLabel</option>')),
			array(
				array('test' => array(array('fluidcontent_core', 'label', 'icon'))),
				array(),
				array(),
				array('row' => array('CType' => 'not-test')),
				array('<select', '<option')
			),
			array(
				array('test' => array('fluidcontent_core' => array('fluidcontent_core', 'label', 'icon'))),
				array('test' => array('fluidcontent_core' => array('Test'))),
				array('mode' => CoreContentProvider::MODE_PRESELECT, 'version' => 'fluidcontent_core'),
				array('row' => array('CType' => 'test', 'content_variant' => 'fluidcontent_core', 'content_version' => 'Test')),
				array('<select', '<option', 'value="Test"', 'selected="selected"')
			),
			array(
				array('test' => array(array('fluidcontent_core', 'label', 'icon'))),
				array('test' => array('fluidcontent_core' => array('Test'))),
				array('mode' => CoreContentProvider::MODE_PRESELECT, 'version' => 'Test', 'variant' => 'fluidcontent_core'),
				array('row' => array('CType' => 'test', 'content_variant' => '', 'content_version' => '')),
				array('<select', '<option', 'value="Test"', 'selected="selected"')
			),
		);
	}

}
