<?php
namespace FluidTYPO3\FluidcontentCore\Provider;
/*****************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@namelesscoder.net>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *****************************************************************/

use FluidTYPO3\Flux\Form;
use FluidTYPO3\Flux\Provider\ProviderInterface;
use FluidTYPO3\Flux\Utility\ExtensionNamingUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * ConfigurationProvider for records in tt_content
 *
 * This Configuration Provider has the lowest possible priority
 * and is only used to execute a set of hook-style methods for
 * processing records. This processing ensures that relationships
 * between content elements get stored correctly -
 *
 * @package Flux
 * @subpackage Provider
 */
class ContentProvider extends \FluidTYPO3\Flux\Provider\ContentProvider implements ProviderInterface {

	/**
	 * @var string
	 */
	protected $extensionKey = 'fluidcontent_core';

	/**
	 * @var integer
	 */
	protected $priority = 90;

	/**
	 * @var string
	 */
	protected $tableName = 'tt_content';

	/**
	 * @var string
	 */
	protected $fieldName = 'pi_flexform';

	/**'
	 * @param array $row
	 * @param string $table
	 * @param string $field
	 * @param string $extensionKey
	 * @return boolean
	 */
	public function trigger(array $row, $table, $field, $extensionKey = NULL) {
		if ($table !== $this->tableName) {
			return FALSE;
		}
		$contentObjectType = $row['CType'];
		$trigger = in_array($contentObjectType, $GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types']);
		return $trigger;
	}

	/**
	 * @param array $row
	 * @return string
	 */
	public function getTemplatePathAndFilename(array $row) {
		if (TRUE === $this->trigger($row, $this->tableName, $this->fieldName)) {
			$paths = $this->getTemplatePaths($row);
			return $paths['templateRootPath'] . '/Content/' . ucfirst($row['CType']) . '.html';
		}
		return parent::getTemplatePathAndFilename($row);
	}


}
