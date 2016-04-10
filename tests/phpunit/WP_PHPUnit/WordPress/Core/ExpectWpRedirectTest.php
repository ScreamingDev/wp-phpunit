<?php

class ExpectWpRedirectTest extends PHPUnit_Framework_TestCase {
	public function testItCanCheckForTheLocation() {
		$location = uniqid();

		\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( $location, anything() )->times( 1 );

		wp_redirect( uniqid() );
		wp_redirect( $location );

		\Mockery::close();
	}

	public function testItCanCheckForTheStatus() {
		$location = uniqid();

		\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( anything(), 500 )->times( 1 );

		wp_redirect( $location, 303 );
		wp_redirect( $location, 500 );

		\Mockery::close();
	}

	public function testItExpectsWpRedirectToBeCalled() {
		\WP_PHPUnit::wp()->core()->expectWpRedirect();

		wp_redirect( '' );

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItRecognizesMissingLocations() {
		\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( uniqid(), anything() )->times( 1 );

		wp_redirect( '' );

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsOutOfBoundsExceptionWhenWpRedirectIsNotCalled() {
		\WP_PHPUnit::wp()->core()->expectWpRedirect();

		\Mockery::close();
	}

	public function testTheAmountOfExpectedCallsCanBeChanged() {
		\WP_PHPUnit::wp()->core()->expectWpRedirect()->times( 3 );

		wp_redirect( '' );
		wp_redirect( '' );
		wp_redirect( '' );

		\Mockery::close();
	}

	protected function tearDown() {
		\Mockery::close();
	}


}