<?php

class ExpectAction extends PHPUnit_Framework_TestCase {
	public function testItCanWatchOnFilterWithSpecificArguments() {
		$tag   = uniqid( 'wp_phpunit' );
		$value = uniqid( 'correct_one_' );

		\WP_PHPUnit::wp()->action()->expect( $tag )->with( $value )->atMost()->once();
		\WP_PHPUnit::wp()->action()->expect( $tag )->with( $value );

		do_action( $tag, uniqid( 'other_' ) );
		do_action( $tag, $value );
		do_action( $tag, uniqid( 'other_' ) );

		\Mockery::close();
	}

	public function testItRecognizesIfAnActionHasRun() {
		$action = uniqid( 'wp_phpunit' );
		\WP_PHPUnit::wp()->action()->expect( $action );

		do_action( $action );
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsOutOfBoundsExceptionIfTheActionHasNotRun() {
		$action = uniqid( 'wp_phpunit' );

		\WP_PHPUnit::wp()->action()->expect( $action );

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testTheAmountOfExpectedCallsCanBeChanged() {
		$action = uniqid( 'wp_phpunit' );
		\WP_PHPUnit::wp()->action()->expect( $action )->atLeast()->twice();

		do_action( $action );

		\Mockery::close();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}