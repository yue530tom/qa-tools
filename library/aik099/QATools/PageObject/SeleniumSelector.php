<?php
/**
 * This file is part of the qa-tools library.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @copyright Alexander Obuhovich <aik.bold@gmail.com>
 * @link      https://github.com/aik099/qa-tools
 */

namespace aik099\QATools\PageObject;


use Behat\Mink\Selector\SelectorInterface;
use Behat\Mink\Selector\SelectorsHandler;
use aik099\QATools\PageObject\Exceptions\WebElementException;

/**
 * Class for handling Selenium-style element selectors.
 *
 * @method \Mockery\Expectation shouldReceive
 *
 * @link http://bit.ly/17fhZ7Z
 */
class SeleniumSelector implements SelectorInterface
{

	/**
	 * Reference to selectors handler, where this selector was registered.
	 *
	 * @var SelectorsHandler
	 */
	private $_handler;

	/**
	 * Creates instance of SeleniumSelector class.
	 *
	 * @param SelectorsHandler $selectors_handler Mink selectors handler.
	 */
	public function __construct(SelectorsHandler $selectors_handler)
	{
		$this->_handler = $selectors_handler;
	}

	/**
	 * Translates provided locator into XPath.
	 *
	 * @param mixed $locator Current selector locator.
	 *
	 * @return string
	 * @throws WebElementException When used selector is broken or not implemented.
	 */
	public function translateToXPath($locator)
	{
		if ( !$locator || !is_array($locator) ) {
			throw new WebElementException('Incorrect Selenium selector format');
		}

		list ($selector, $locator) = each($locator);
		$locator = trim($locator);

		if ( $selector == How::CLASS_NAME ) {
			$locator = $this->_handler->xpathLiteral(' ' . $locator . ' ');

			return "descendant-or-self::*[@class and contains(concat(' ', normalize-space(@class), ' '), {$locator})]";
		}
		elseif ( $selector == How::CSS ) {
			return $this->_handler->selectorToXpath('css', $locator);
		}
		elseif ( $selector == How::ID ) {
			return 'descendant-or-self::*[@id = ' . $this->_handler->xpathLiteral($locator) . ']';
		}
		elseif ( $selector == How::NAME ) {
			return 'descendant-or-self::*[@name = ' . $this->_handler->xpathLiteral($locator) . ']';
		}
		elseif ( $selector == How::TAG_NAME ) {
			return 'descendant-or-self::' . $locator;
		}
		elseif ( $selector == How::XPATH ) {
			return $locator;
		}

//		case How::LINK_TEXT:
//		case How::PARTIAL_LINK_TEXT:

		throw new WebElementException(sprintf('Selector type "%s" not yet implemented', $selector));
	}

}
