<?php

$GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'] = array(
	'header', 'text', 'image', 'textpic', 'bullets', 'uploads', 'table', 'media', 'mailform', 'search', 'menu', 'shortcut', 'div', 'html', 'default'
);
for ($i = 0; $i < count($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types']); $i++) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FluidTYPO3.FluidcontentCore',
		ucfirst($GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'][$i]),
		array('Content' => $GLOBALS['TYPO3_CONF_VARS']['FluidTYPO3.FluidcontentCore']['types'][$i]),
		array());
}

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\FluidcontentCore\Provider\ContentProvider');
