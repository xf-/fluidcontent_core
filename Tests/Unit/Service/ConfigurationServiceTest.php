<?php
namespace FluidTYPO3\FluidcontentCore\Tests\Unit\Service;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\FluidcontentCore\Service\ConfigurationService;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class ConfigurationServiceTest
 */
class ConfigurationServiceTest extends UnitTestCase {

	/**
	 * @return void
	 */
	public function testGetAllRegisteredVariants() {
		$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['variants'] = array('foo' => 'bar');
		$instance = new ConfigurationService();
		$result = $instance->getAllRegisteredVariants();
		$this->assertEquals(array('foo' => 'bar'), $result);
		unset($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['variants']);
	}

}
