<?php
namespace FluidTYPO3\FluidcontentCore\Hooks;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\FluidcontentCore\Service\UpdateService;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * InstallSignalSlot
 */
class InstallSignalSlot implements SingletonInterface {
	/**
	 * Install AddionalConfiguration
	 */
	public function installAddionalConfiguration() {
		$updateService = new UpdateService();
		$updateService->main();
	}
}
