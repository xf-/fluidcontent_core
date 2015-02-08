<?php
namespace FluidTYPO3\FluidcontentCore\Tests\Unit\UserFunction;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Tests\BaseTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ProviderFieldTest
 */
class ProviderFieldTest extends BaseTestCase {

	/**
	 * @return void
	 */
	public function testPerformsInjections() {
		$instance = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')
			->get('FluidTYPO3\\FluidcontentCore\\UserFunction\\ProviderField');
		$this->assertAttributeInstanceOf('TYPO3\\CMS\\Extbase\\Object\\ObjectManagerInterface', 'objectManager', $instance);
		$this->assertAttributeInstanceOf('FluidTYPO3\\FluidcontentCore\\Provider\\CoreContentProvider', 'provider', $instance);
	}

}
