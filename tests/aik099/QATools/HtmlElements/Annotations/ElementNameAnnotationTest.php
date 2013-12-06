<?php
/**
 * This file is part of the qa-tools library.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @copyright Alexander Obuhovich <aik.bold@gmail.com>
 * @link      https://github.com/aik099/qa-tools
 */

namespace tests\aik099\QATools\HtmlElements\Annotations;


use aik099\QATools\HtmlElements\Annotations\ElementNameAnnotation;

class ElementNameAnnotationTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testInitAnnotation()
	{
		$expected = 'test';

		$annotation = new ElementNameAnnotation();
		$annotation->initAnnotation(array(0 => $expected));
		$this->assertEquals($expected, $annotation->name);
	}

}
