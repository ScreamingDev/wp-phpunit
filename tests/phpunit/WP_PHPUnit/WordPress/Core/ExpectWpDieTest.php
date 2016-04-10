<?php

class ExpectWpDieTest extends PHPUnit_Framework_TestCase {
	public function testItRecognizesIfWpDieHasRun() {
		\WP_PHPUnit::wp()->core()->expectWpDie();

		wp_die();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsOutOfBoundsExceptionIfWpDieHasNotRun() {
		\WP_PHPUnit::wp()->core()->expectWpDie();

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testTheAmountOfExpectedCallsCanBeChanged() {
		\WP_PHPUnit::wp()->core()->expectWpDie()->atLeast()->twice();

		wp_die();

		\Mockery::close();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}