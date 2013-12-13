<?php

$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'] = array(
	'header', 'text', 'image', 'textpic', 'bullets', 'uploads', 'table', 'media', 'mailform', 'search', 'menu', 'shortcut', 'div', 'html', 'default'
);
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

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\FluidcontentCore\Provider\ContentProvider');

$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
	'fluidcontentcore/Configuration/TypoScript/',
);
