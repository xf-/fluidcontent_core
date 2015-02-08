<?php
namespace FluidTYPO3\FluidcontentCore\Tests\Unit\Provider;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Tests\BaseTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class AbstractCoreContentControllerTest
 */
class AbstractCoreContentControllerTest extends BaseTestCase {

	/**
	 * @return void
	 */
	public function testInitializeProvider() {
		$instance = $this->getMockForAbstractClass('FluidTYPO3\\FluidcontentCore\\Controller\\AbstractCoreContentController');
		$instance->injectObjectManager(GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager'));
		$this->callInaccessibleMethod($instance, 'initializeProvider');
		$this->assertAttributeInstanceOf('FluidTYPO3\\FluidcontentCore\\Provider\\CoreContentProvider', 'provider', $instance);
	}

	/**
	 * @return void
	 */
	public function testInitializeViewVariables() {
		$instance = $this->getMockForAbstractClass(
			'FluidTYPO3\\FluidcontentCore\\Controller\\AbstractCoreContentController',
			array(), '', FALSE, FALSE, FALSE, array('getRecord', 'initializeSettings', 'initializeViewObject')
		);
		$instance->expects($this->atLeastOnce())->method('getRecord')->willReturn(array('uid' => 0));
		$instance->expects($this->once())->method('initializeSettings');
		$instance->expects($this->once())->method('initializeViewObject');
		$service = $this->getMock('FluidTYPO3\\Flux\\Service\\FluxService', array('convertFlexFormContentToArray'));
		$service->expects($this->once())->method('convertFlexFormContentToArray')->willReturn(array());
		$instance->injectObjectManager(GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager'));
		$instance->injectConfigurationService($service);
		$instance->initializeView(new StandaloneView());
	}

}
