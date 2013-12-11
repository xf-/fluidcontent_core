<?php
namespace FluidTYPO3\FluidcontentCore\Controller;

use FluidTYPO3\Flux\Controller\AbstractFluxController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ContentController extends AbstractFluxController {

	/**
	 * @var string
	 */
	protected $fluxRecordField = 'pi_flexform';

	/**
	 * @var string
	 */
	protected $fluxTableName = 'tt_content';

	/**
	 * @return void
	 */
	protected function initializeProvider() {
		$this->provider = $this->objectManager->get('FluidTYPO3\FluidcontentCore\Provider\ContentProvider');
	}

	/**
	 * @return void
	 */
	public function defaultAction() {

	}

	/**
	 * @return void
	 */
	public function headerAction() {

	}

	/**
	 * @return void
	 */
	public function textAction() {

	}

	/**
	 * @return void
	 */
	public function imageAction() {

	}

	/**
	 * @return void
	 */
	public function textpicAction() {

	}

	/**
	 * @return void
	 */
	public function bulletsAction() {

	}

	/**
	 * @return void
	 */
	public function uploadsAction() {

	}

	/**
	 * @return void
	 */
	public function tableAction() {

	}

	/**
	 * @return void
	 */
	public function mediaAction() {

	}

	/**
	 * @return void
	 */
	public function mailformAction() {

	}

	/**
	 * @return void
	 */
	public function searchAction() {

	}

	/**
	 * @return void
	 */
	public function menuAction() {

	}

	/**
	 * @return void
	 */
	public function shortcutAction() {

	}

	/**
	 * @return void
	 */
	public function divAction() {

	}

	/**
	 * @return void
	 */
	public function htmlAction() {

	}

}
