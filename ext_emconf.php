<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "fluidcontent_core".
 *
 * Auto generated 11-12-2013 01:44
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Fluid Styled Content',
	'description' => 'Not CSS styled content - Fluid styled content',
	'category' => 'misc',
	'shy' => 0,
	'version' => '0.0.1',
	'dependencies' => 'cms,extbase,fluid,flux,fluidcontent,vhs',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => 'top',
	'module' => '',
	'state' => 'experimental',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Claus Due',
	'author_email' => 'claus@namelesscoder.net',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5-6.2.99',
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
			'flux' => '',
			'vhs' => '',
		),
		'conflicts' => array(
			'css_styled_content' => ''
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:0:{}',
	'suggests' => array(
	),
);
