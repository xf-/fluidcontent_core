<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['label'] = NULL;
$GLOBALS['TCA']['tt_content']['columns']['content_options'] = array(
	'label' => NULL,
	'config' => array(
		'type' => 'flex'
	)
);
$GLOBALS['TCA']['tt_content']['columns']['content_variant'] = array(
	'label' => 'LLL:EXT:fluidcontent_core/Resources/Private/Language/locallang.xlf:tt_content.content_variant',
	'exclude' => 1,
	'config' => array(
		'type' => 'user',
		'userFunc' => 'FluidTYPO3\FluidcontentCore\UserFunction\ProviderField->createVariantsField',
	)
);
$GLOBALS['TCA']['tt_content']['columns']['content_version'] = array(
	'label' => 'LLL:EXT:fluidcontent_core/Resources/Private/Language/locallang.xlf:tt_content.content_version',
	'exclude' => 1,
	'config' => array(
		'type' => 'user',
		'userFunc' => 'FluidTYPO3\FluidcontentCore\UserFunction\ProviderField->createVersionsField',
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'general', 'content_variant, content_version', 'after:CType');


$GLOBALS['TCA']['tt_content']['palettes']['frames']['showitem'] = 'content_options';
$GLOBALS['TCA']['tt_content']['palettes']['header']['showitem'] = 'header';
$GLOBALS['TCA']['tt_content']['palettes']['headers']['showitem'] = 'header';
$GLOBALS['TCA']['tt_content']['columns']['header']['label'] = NULL;
$GLOBALS['TCA']['tt_content']['ctrl']['requestUpdate'] .= ',content_variant,content_version';

unset(
	$GLOBALS['TCA']['tt_content']['types']['swfobject'],
	$GLOBALS['TCA']['tt_content']['types']['qtobject'],
	$GLOBALS['TCA']['tt_content']['types']['multimedia'],
	$GLOBALS['TCA']['tt_content']['types']['mailform'],
	$GLOBALS['TCA']['tt_content']['types']['search'],
	$GLOBALS['TCA']['tt_content']['types']['textpic'],
	$GLOBALS['TCA']['tt_content']['columns']['text_properties'],
	$GLOBALS['TCA']['tt_content']['columns']['text_align'],
	$GLOBALS['TCA']['tt_content']['columns']['text_color'],
	$GLOBALS['TCA']['tt_content']['columns']['text_face'],
	$GLOBALS['TCA']['tt_content']['columns']['text_size'],
	$GLOBALS['TCA']['tt_content']['columns']['image_compression'],
	$GLOBALS['TCA']['tt_content']['columns']['image_effects'],
	$GLOBALS['TCA']['tt_content']['columns']['image_frames'],
	$GLOBALS['TCA']['tt_content']['columns']['image_zoom'],
	$GLOBALS['TCA']['tt_content']['columns']['imageborder'],
	$GLOBALS['TCA']['tt_content']['columns']['linkToTop'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_title'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_bypass'],
	$GLOBALS['TCA']['tt_content']['columns']['accessibility_bypass_text'],
	$GLOBALS['TCA']['tt_content']['columns']['table_bgColor'],
	$GLOBALS['TCA']['tt_content']['columns']['table_border'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellspacing'],
	$GLOBALS['TCA']['tt_content']['columns']['table_cellpadding'],
	$GLOBALS['TCA']['tt_content']['columns']['category_field'],
	$GLOBALS['TCA']['tt_content']['palettes']['imageblock'],
	$GLOBALS['TCA']['tt_content']['palettes']['imagelinks'],
	$GLOBALS['TCA']['tt_content']['palettes']['image_accessibility'],
	$GLOBALS['TCA']['tt_content']['palettes']['image_settings'],
	$GLOBALS['TCA']['tt_content']['palettes']['table']
);
