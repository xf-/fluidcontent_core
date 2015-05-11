<?php
namespace FluidTYPO3\FluidcontentCore\Controller;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\FluidcontentCore\Provider\CoreContentProvider;
use FluidTYPO3\Flux\Controller\AbstractFluxController;
use FluidTYPO3\Flux\Utility\RecursiveArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Class CoreContentController
 */
class CoreContentController extends AbstractFluxController {

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
	public function menuAction() {
		$record = $this->getRecord();
		$type = $record[CoreContentProvider::MENUTYPE_FIELDNAME];
		switch ($type) {
			case CoreContentProvider::MENU_CATEGORIZEDPAGES:
				$selected = $record['selected_categories'];
				$bindings = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'uid_foreign',
					'sys_category_record_mm',
					"fieldname = 'categories' AND tablenames = 'pages' AND uid_local IN (" . $selected . ')',
					'uid_foreign',
					'sorting ASC'
				);
				$pageUids = array_map('array_pop', $bindings);
				$this->view->assign('pageUids', $pageUids);
				break;
			case CoreContentProvider::MENU_CATEGORIZEDCONTENT:
				$selected = $record['selected_categories'];
				$bindings = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'uid_foreign',
					'sys_category_record_mm',
					"fieldname = 'categories' AND tablenames = 'tt_content' AND uid_local IN (" . $selected . ')',
					'uid_foreign',
					'sorting ASC'
				);
				$contentUids = array_map('array_pop', $bindings);
				$this->view->assign('contentUids', $contentUids);
				break;
			default:
		}
	}

	/**
	 * @return void
	 */
	public function shortcutAction() {

		$record = $this->getRecord();
		$contentUids = array_map(function($index) {
			if (0 !== strpos($index, 'tt_content_') && FALSE === MathUtility::canBeInterpretedAsInteger($index)) {
				return FALSE;
			}
			return str_replace('tt_content_', '', $index);
		}, GeneralUtility::trimExplode(',', $record['records']));
		$this->view->assign('contentUids', implode(',', array_filter($contentUids)));
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
