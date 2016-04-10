<?php

namespace WP_PHPUnit\Framework;

class Test_Case extends \PHPUnit_Framework_TestCase {
	/**
	 * @var \WP_PHPUnit
	 */
	protected $_wp = null;

	public function wp() {
		return \WP_PHPUnit::wp();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}