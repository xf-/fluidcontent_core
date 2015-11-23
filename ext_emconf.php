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
	'category' => 'fe',
	'shy' => 0,
	'version' => '1.4.0',
	'dependencies' => 'cms,flux,vhs',
	'conflicts' => 'css_styled_content,fluid_styled_content',
	'priority' => 'top',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'FluidTYPO3 Team',
	'author_email' => 'claus@namelesscoder.net',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.6.0-7.6.99',
			'cms' => '',
			'flux' => '7.2.0-7.3.99',
			'vhs' => '2.1.0-2.4.99',
		),
		'conflicts' => array(
			'css_styled_content' => '',
			'fluid_styled_content' => ''
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:0:{}',
	'suggests' => array(
	),
);
