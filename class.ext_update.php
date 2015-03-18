<?php

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Updater Script for fluidcontent_core
 *
 * @package FluidcontentCore
 */
class ext_update {

	/**
	 * @var string
	 */
	protected $sourceConfigurationFile;

	/**
	 * @var string
	 */
	protected $targetConfigurationFile = 'typo3conf/AdditionalConfiguration.php';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->targetConfigurationFile = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($this->targetConfigurationFile);
	}

	/**
	 * @return boolean
	 */
	public function access() {
		return (TRUE === $this->existingFileIsMigratable() && TRUE === \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('fluidcontent_core'));
	}

	/**
	 * @return string
	 */
	public function main() {
		$this->sourceConfigurationFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('fluidcontent_core', 'Resources/Private/Configuration/AdditionalConfiguration.php');
		if (TRUE === $this->existingFileIsMigratable()) {
			$this->installAdditionalConfiguration();
			return 'Deployed "' . $this->targetConfigurationFile . '" to "' . $this->targetConfigurationFile . '"';
		}
		return 'No action performed';
	}

	/**
	 * @return boolean
	 */
	protected function existingFileIsMigratable() {
		$migrationHistoryFiles = glob(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('fluidcontent_core', 'Migrations/Configuration/AdditionalConfiguration*.php'));
		if (FALSE === file_exists($this->targetConfigurationFile)) {
			return TRUE;
		}
		$targetContent = file_get_contents($this->targetConfigurationFile);
		foreach ($migrationHistoryFiles as $migrationHistoryFile) {
			if ($targetContent === file_get_contents($migrationHistoryFile)) {
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * @return void
	 */
	protected function installAdditionalConfiguration() {
		copy($this->sourceConfigurationFile, $this->targetConfigurationFile);
	}

}
