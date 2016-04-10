<?php

class ExpectWpDieTest extends PHPUnit_Framework_TestCase {
	public function testItRecognizesIfWpDieHasRun() {
		\WP_PHPUnit::wp()->expectWpDie();

		wp_die();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsOutOfBoundsExceptionIfWpDieHasNotRun() {
		\WP_PHPUnit::wp()->expectWpDie();

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testTheAmountOfExpectedCallsCanBeChanged() {
		\WP_PHPUnit::wp()->expectWpDie()->atLeast()->twice();

		wp_die();

		\Mockery::close();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}