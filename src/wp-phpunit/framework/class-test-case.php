<?php

namespace WP_PHPUnit\Framework;

class Test_Case extends \PHPUnit_Framework_TestCase {
	/**
	 * @return \WP_PHPUnit\WordPress
	 */
	public function wp() {
		return \WP_PHPUnit::wp();
	}

	public function tearDown() {
		\WP_PHPUnit::tearDown();
	}
}