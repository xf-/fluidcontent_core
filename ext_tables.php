<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Fluid Styled Content');
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

$TCA['tt_content']['palettes']['frames']['showitem'] = 'pi_flexform';
