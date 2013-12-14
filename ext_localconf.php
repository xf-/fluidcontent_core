<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
	'fluidcontentcore/Configuration/TypoScript/',
);

$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'] = array(
	'header', 'text', 'image', 'textpic', 'bullets', 'uploads', 'table', 'media', 'mailform', 'search', 'menu', 'shortcut', 'div', 'html', 'default'
);

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\FluidcontentCore\Provider\ContentProvider');


#\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Fluid styled content');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:fluidcontent_core/Configuration/TypoScript/setup.txt">');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
TCEFORM.tt_content {
	text_properties.disabled=1
	text_align.disabled=1
	text_color.disabled=1
	text_face.disabled=1
	text_size.disabled=1
	image_frames.disabled = 1
	CType.removeItems = swfobject,qtobject,multimedia
}');

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
		array('Content' => $GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'][$i]),
		array());
}
