<?php
namespace FluidTYPO3\FluidcontentCore\Provider;

/*
 * This file is part of the FluidTYPO3/FluidcontentCore project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flux\Form;
use FluidTYPO3\Flux\Provider\AbstractProvider;
use FluidTYPO3\Flux\Provider\ProviderInterface;
use FluidTYPO3\Flux\Utility\ExtensionNamingUtility;
use FluidTYPO3\Flux\Utility\PathUtility;
use FluidTYPO3\Flux\Utility\ResolveUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * ConfigurationProvider for records in tt_content
 *
 * This Configuration Provider has the lowest possible priority
 * and is only used to execute a set of hook-style methods for
 * processing records. This processing ensures that relationships
 * between content elements get stored correctly.
 */
class CoreContentProvider extends AbstractProvider implements ProviderInterface {

	const MODE_RECORD = 'record';
	const MODE_PRESELECT = 'preselect';
	const CTYPE_MENU = 'menu';
	const CTYPE_TABLE = 'table';
	const CTYPE_FIELDNAME = 'CType';
	const MENUTYPE_FIELDNAME = 'menu_type';
	const MENU_SELECTEDPAGES = 0;
	const MENU_SUBPAGESOFSELECTEDPAGES = 1;
	const MENU_SUBPAGESOFSELECTEDPAGESWITHABSTRACT = 4;
	const MENU_SUBPAGESOFSELECTEDPAGESWITHSECTIONS = 7;
	const MENU_SITEMAP = 2;
	const MENU_SITEMAPSOFSELECTEDPAGES = 8;
	const MENU_SECTIONINDEX = 3;
	const MENU_RECENTLYUPDATED = 5;
	const MENU_RELATEDPAGES = 6;
	const MENU_CATEGORIZEDPAGES = 'categorized_pages';
	const MENU_CATEGORIZEDCONTENT = 'categorized_content';
	const THEAD_NONE = 'none';
	const THEAD_TOP = 'top';
	const THEAD_LEFT = 'left';

	/**
	 * @var string
	 */
	protected $extensionKey = 'fluidcontent_core';

	/**
	 * @var string
	 */
	protected $packageName = 'FluidTYPO3.FluidcontentCore';

	/**
	 * @var integer
	 */
	protected $priority = 0;

	/**
	 * @var string
	 */
	protected $tableName = 'tt_content';

	/**
	 * @var string
	 */
	protected $fieldName = 'content_options';

	/**
	 * @var array
	 */
	protected static $variants = array();

	/**
	 * @var array
	 */
	protected static $versions = array();

	/**
	 * Filled with an integer-or-string -> Fluid section name
	 * map which maps machine names of menu types to human
	 * readable values that are sensible as Fluid section names.
	 * When type is selected in menu element, corresponding
	 * section gets rendered.
	 *
	 * @var array
	 */
	protected $menuTypeToSectionNameMap = array(
		self::MENU_SELECTEDPAGES => 'SelectedPages',
		self::MENU_SUBPAGESOFSELECTEDPAGES => 'SubPagesOfSelectedPages',
		self::MENU_SUBPAGESOFSELECTEDPAGESWITHABSTRACT => 'SubPagesOfSelectedPagesWithAbstract',
		self::MENU_SUBPAGESOFSELECTEDPAGESWITHSECTIONS => 'SubPagesOfSelectedPagesWithSections',
		self::MENU_SITEMAP => 'SiteMap',
		self::MENU_SITEMAPSOFSELECTEDPAGES => 'SiteMapsOfSelectedPages',
		self::MENU_SECTIONINDEX => 'SectionIndex',
		self::MENU_RECENTLYUPDATED => 'RecentlyUpdated',
		self::MENU_RELATEDPAGES => 'RelatedPages',
		self::MENU_CATEGORIZEDPAGES => 'CategorizedPages',
		self::MENU_CATEGORIZEDCONTENT => 'CategorizedContent'
	);

	/**
	 * @return void
	 */
	public function initializeObject() {
		$typoScript = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
		$settings = (array) $typoScript['plugin.']['tx_fluidcontentcore.']['settings.'];
		$settings = GeneralUtility::removeDotsFromTS($settings);
		$paths = (array) $typoScript['plugin.']['tx_fluidcontentcore.']['view.'];
		$paths = GeneralUtility::removeDotsFromTS($paths);
		$paths = PathUtility::translatePath($paths);
		$this->templateVariables['settings'] = $settings;
		$this->templatePaths = $paths;
		$this->templatePathAndFilename = PathUtility::translatePath($settings['defaults']['template']);
	}

	/**
	 * Note: This Provider will -always- trigger on any tt_content record
	 * but has the lowest possible (0) priority, ensuring that any
	 * Provider which wants to take over, can do so.
	 *
	 * @param array $row
	 * @param string $table
	 * @param string $field
	 * @param string $extensionKey
	 * @return boolean
	 */
	public function trigger(array $row, $table, $field, $extensionKey = NULL) {
		return ($table === $this->tableName && ($field === $this->fieldName || NULL === $field));
	}

	/**
	 * @param array $row
	 * @return Form
	 */
	public function getForm(array $row) {
		if (self::CTYPE_MENU === $row[self::CTYPE_FIELDNAME]) {
			// addtional menu variables
			$menuType = $row[self::MENUTYPE_FIELDNAME];
			$partialTemplateName = $this->menuTypeToSectionNameMap[$menuType];
			$this->templateVariables['menuPartialTemplateName'] = $partialTemplateName;
			$this->templateVariables['pageUids'] = GeneralUtility::trimExplode(',', $row['pages']);
		}
		if (self::CTYPE_TABLE == $row[self::CTYPE_FIELDNAME]) {
			$this->templateVariables['tableHeadPositions'] = array(
				self::THEAD_NONE => LocalizationUtility::translate('tableHead.none', 'fluidcontent_core'),
				self::THEAD_TOP => LocalizationUtility::translate('tableHead.top', 'fluidcontent_core'),
				self::THEAD_LEFT => LocalizationUtility::translate('tableHead.left', 'fluidcontent_core'),
			);
		}
		return parent::getForm($row);
	}

	/**
	 * @param string $contentType
	 * @return array
	 */
	public function getVariantExtensionKeysForContentType($contentType) {
		if (FALSE === isset($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['variants'][$contentType])) {
			return array();
		}
		if (TRUE === isset(self::$variants[$contentType])) {
			return self::$variants[$contentType];
		}
		self::$variants[$contentType] = array();
		foreach ($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['variants'][$contentType] as $variantExtensionKey) {
			$icon = NULL;
			if (TRUE === is_array($variantExtensionKey) && 3 === count($variantExtensionKey)) {
				list ($variantExtensionKey, $labelReference, $icon) = $variantExtensionKey;
			} elseif (TRUE === is_array($variantExtensionKey) && 2 === count($variantExtensionKey)) {
				list ($variantExtensionKey, $labelReference) = $variantExtensionKey;
			} else {
				$actualKey = ExtensionNamingUtility::getExtensionKey($variantExtensionKey);
				$labelReference = 'fluidcontent_core.variantLabel';
			}
			$templatePathAndFilename = $this->getTemplatePathAndFilenameByExtensionKeyAndContentTypeAndVariantAndVersion($variantExtensionKey, $contentType, $variantExtensionKey);
			if (TRUE === file_exists(PathUtility::translatePath($templatePathAndFilename))) {
				array_push(self::$variants[$contentType], array($variantExtensionKey, $labelReference, $icon));
			}
		}
		return self::$variants[$contentType];
	}

	/**
	 * @param string $contentType
	 * @param string $variant
	 * @return array
	 */
	public function getVariantVersions($contentType, $variant) {
		if (TRUE === isset(self::$versions[$contentType][$variant])) {
			return self::$versions[$contentType][$variant];
		}
		if (FALSE === isset(self::$versions[$contentType])) {
			self::$versions[$contentType] = array();
		}
		$paths = $this->configurationService->getViewConfigurationForExtensionName($variant);
		$versionsDirectory = rtrim($paths['templateRootPath'], '/') . '/CoreContent/' . ucfirst($contentType) . '/';
		$versionsDirectory = PathUtility::translatePath($versionsDirectory);
		if (FALSE === is_dir($versionsDirectory)) {
			self::$versions[$contentType][$variant] = array();
		} else {
			$files = glob($versionsDirectory . '*.html');
			foreach ($files as &$file) {
				$file = basename($file, '.html');
			}
			self::$versions[$contentType][$variant] = $files;
		}
		return self::$versions[$contentType][$variant];
	}

	/**
	 * @param string $extensionKey
	 * @param string $contentType
	 * @param string $variant
	 * @param string $version
	 * @return string
	 */
	protected function getTemplatePathAndFilenameByExtensionKeyAndContentTypeAndVariantAndVersion($extensionKey, $contentType, $variant = NULL, $version = NULL) {
		if (FALSE === empty($variant)) {
			$extensionKey = $variant;
		}
		$paths = $this->configurationService->getViewConfigurationForExtensionName($extensionKey);
		$controllerName = 'CoreContent';
		$controllerAction = $contentType;
		$format = 'html';
		if (FALSE === empty($version)) {
			$controllerAction .= '/' . $version;
		}

		$templatePathAndFilename = ResolveUtility::resolveTemplatePathAndFilenameByPathAndControllerNameAndActionAndFormat($paths, $controllerName, $controllerAction, $format);
		return $templatePathAndFilename;
	}

	/**
	 * @param array $row
	 * @return string|NULL
	 */
	public function getExtensionKey(array $row) {
		if (FALSE === empty($row['content_variant'])) {
			return $row['content_variant'];
		}
		return $this->extensionKey;
	}

	/**
	 * @param array $row
	 * @return string
	 */
	public function getControllerExtensionKeyFromRecord(array $row) {
		if (FALSE === empty($row['content_variant'])) {
			return $row['content_variant'];
		}
		return $this->extensionKey;
	}

	/**
	 * @param array $row
	 * @return string
	 */
	public function getTemplatePathAndFilename(array $row) {
		$extensionKey = $this->getExtensionKey($row);
		$variant = $this->getVariant($row);
		$version = $this->getVersion($row);
		$template = $this->getTemplatePathAndFilenameByExtensionKeyAndContentTypeAndVariantAndVersion($extensionKey, $row['CType'], $variant, $version);
		if (TRUE === file_exists(PathUtility::translatePath($template))) {
			return GeneralUtility::getFileAbsFileName($template);
		}
		return GeneralUtility::getFileAbsFileName($this->templatePathAndFilename);
	}

	/**
	 * @return array
	 */
	public function getDefaults() {
		$typoScript = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
		$defaults = (array) $typoScript['plugin.']['tx_fluidcontentcore.']['settings.']['defaults.'];
		$defaults = GeneralUtility::removeDotsFromTS($defaults);
		return $defaults;
	}

	/**
	 * @param array $row
	 * @return string
	 */
	protected function getVariant(array $row) {
		$defaults = $this->getDefaults();
		if (self::MODE_RECORD !== $defaults['mode'] && TRUE === empty($row['content_variant'])) {
			return $defaults['variant'];
		}
		return $row['content_variant'];
	}

	/**
	 * @param array $row
	 * @return string
	 */
	protected function getVersion(array $row) {
		$defaults = $this->getDefaults();
		if (self::MODE_RECORD !== $defaults['mode'] && TRUE === empty($row['content_version'])) {
			return $defaults['version'];
		}
		return $row['content_version'];
	}

	/**
	 * @param array $row
	 * @return string
	 */
	public function getControllerActionFromRecord(array $row) {
		return strtolower($row['CType']);
	}

	/**
	 * @param string $operation
	 * @param integer $id
	 * @param array $row
	 * @param DataHandler $reference
	 * @return void
	 */
	public function postProcessRecord($operation, $id, array &$row, DataHandler $reference) {
		$defaults = $this->getDefaults();
		if (self::MODE_RECORD === $defaults['mode']) {
			if (TRUE === empty($row['content_variant'])) {
				$row['content_variant'] = $defaults['variant'];
			}
			if (TRUE === empty($row['content_version'])) {
				$row['content_version'] = $defaults['version'];
			}
		}
		return parent::postProcessRecord($operation, $id, $row, $reference);
	}

	/**
	 * @param array $row
	 * @return array
	 */
	public function getTemplatePaths(array $row) {
		$paths = parent::getTemplatePaths($row);

		$variant = $this->getVariant($row);
		if (FALSE === empty($variant)) {
			$extensionKey = ExtensionNamingUtility::getExtensionKey($variant);
			if (FALSE === empty($extensionKey)) {
				$overlayPaths = $this->configurationService->getViewConfigurationForExtensionName($extensionKey);
				$paths['overlays'][$extensionKey] = $overlayPaths;
			}
		}

		return $paths;
	}

}
