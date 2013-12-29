<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (FALSE === isset($GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'])) {
	$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
		'fluidcontentcore/Configuration/TypoScript/',
	);
}

$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'] = array(
	'header', 'text', 'image', 'bullets', 'uploads', 'table', 'media', 'menu', 'shortcut', 'div', 'html', 'default'
);

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\FluidcontentCore\Provider\ContentProvider');

\FluidTYPO3\Flux\Core::addStaticTypoScript('EXT:fluidcontent_core/Configuration/TypoScript');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:fluidcontent_core/Configuration/TypoScript/setup.txt">');

// Prepare a global variants registration array indexed by CType value.
// To add your own, do fx: $GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['variants']['textpic'][] = 'myextensionkey';
$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['variants'] = array_combine(
	array_values($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types']),
	array_fill(0, count($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types']), array())
);

for ($i = 0; $i < count($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types']); $i++) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FluidTYPO3.FluidcontentCore',
		ucfirst($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'][$i]),
		array('CoreContent' => $GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'][$i]),
		array());
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook']['fluidcontent_core'] = 'FluidTYPO3\FluidcontentCore\Hooks\WizardItemsHookSubscriber';
