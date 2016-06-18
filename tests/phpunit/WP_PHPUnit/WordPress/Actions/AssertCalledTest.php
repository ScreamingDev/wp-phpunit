<?php

class AssertCalledTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsExceptionWhenAnActionHasNotBeenCalled() {
		WP_PHPUnit::wp()->action('foo')->expected();

		\WP_PHPUnit::tearDown();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}