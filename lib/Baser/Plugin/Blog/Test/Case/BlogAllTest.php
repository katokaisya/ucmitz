<?php

/**
 * run all baser blog tests
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2015, baserCMS Users Community <http://sites.google.com/site/baserusers/>
 * @package         Blog.Test.Case
 * @copyright		Copyright 2008 - 2015, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @since			baserCMS v 3.0.7
 * @license			http://basercms.net/license/index.html
 */

/**
 * @package Blog.Test.Case
 */
class BlogAllTest extends PHPUnit_Framework_TestSuite {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('Baser Blog All Tests');

		//$path = __DIR__ . DS;
		//$suite->addTestFile($path . 'BlogAllModelTest.php');

		return $suite;
	}

}
