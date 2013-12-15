<?php
namespace FluidTYPO3\FluidcontentCore\ViewHelpers;
/*****************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@namelesscoder.net>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *****************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * ### Tag building ViewHelper
 *
 * Creates one HTML tag of any type, with various properties
 * like class and ID applied only if arguments are not empty,
 * rather than apply them always - empty or not - if provided.
 *
 * @package Vhs
 * @subpackage ViewHelpers
 */
class TagViewHelper extends AbstractTagBasedViewHelper {

	/**
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerArgument('name', 'string', 'Tag name', TRUE);
	}

	/**
	 * @return string
	 */
	public function render() {
		$content = $this->renderChildren();
		if ('none' === $this->arguments['name']) {
			return $content;
		}
		$this->tag->reset();
		$this->tag->setTagName($this->arguments['name']);
		$this->applyAttributes($this->arguments['additionalAttributes']);
		unset($this->arguments['name'], $this->arguments['additionalAttributes']);
		$this->applyAttributes($this->arguments);
		$this->tag->setContent($content);
		return $this->tag->render();
	}

	/**
	 * @param array $attributes
	 * @return void
	 */
	protected function applyAttributes($attributes) {
		foreach ($attributes as $attributeName => $attributeValue) {
			if ('none' !== $attributeValue && (FALSE === empty($attributeValue) || 0 === $attributeValue || '0' === $attributeValue)) {
				$this->tag->addAttribute($attributeName, $attributeValue);
			}
		}
	}

}
