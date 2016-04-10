<?php

class ExpectAction extends PHPUnit_Framework_TestCase {
	public function testItRecognizesIfAnActionHasRun() {
		$action = uniqid('wp_phpunit');
		\WP_PHPUnit::wp()->action()->expect($action);

		do_action($action);
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsOutOfBoundsExceptionIfTheActionHasNotRun() {
		$action = uniqid('wp_phpunit');

		\WP_PHPUnit::wp()->action()->expect($action);

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testTheAmountOfExpectedCallsCanBeChanged() {
		$action = uniqid('wp_phpunit');
		\WP_PHPUnit::wp()->action()->expect($action)->atLeast()->twice();

		do_action($action);

		\Mockery::close();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}