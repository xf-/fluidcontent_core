<?php
namespace FluidTYPO3\FluidcontentCore\Controller;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flux\Controller\AbstractFluxController;
use FluidTYPO3\Flux\Utility\RecursiveArrayUtility;

/**
 * Class AbstractCoreContentController
 */
abstract class AbstractCoreContentController extends AbstractFluxController {

	/**
	 * @var string
	 */
	protected $fluxRecordField = 'content_options';

	/**
	 * @var string
	 */
	protected $fluxTableName = 'tt_content';

	/**
	 * @return void
	 */
	protected function initializeProvider() {
		$this->provider = $this->objectManager->get('FluidTYPO3\FluidcontentCore\Provider\CoreContentProvider');
	}

	/**
	 * @return void
	 */
	protected function initializeViewVariables() {
		$row = $this->getRecord();
		$flexFormData = $this->configurationService->convertFlexFormContentToArray($row['pi_flexform']);
		$this->settings = RecursiveArrayUtility::merge($this->settings, $flexFormData, FALSE, FALSE);
		parent::initializeViewVariables();
	}

}
