<?php

namespace WP_PHPUnit\Tests\PHPUnit\WordPress\Filter;

class ExpectTest extends \PHPUnit_Framework_TestCase {
	public function testItDoesNotHarmTheValue() {
		$filter = uniqid( 'wp_phpunit' );

		\WP_PHPUnit::wp()->filter()->expect( $filter );

		$before = uniqid();

		$after = apply_filters( $filter, $before );

		$this->assertSame( $before, $after );
	}

	public function testItRecognizesIfAnFilterHasRun() {
		$filter = uniqid( 'wp_phpunit' );

		\WP_PHPUnit::wp()->filter()->expect( $filter );

		apply_filters( $filter, null );

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsOutOfBoundsExceptionIfTheFilterHasNotRun() {
		$tag = uniqid( 'wp_phpunit' );

		\WP_PHPUnit::wp()->filter()->expect( $tag );

		\Mockery::close();

	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testTheAmountOfExpectedCallsCanBeChanged() {
		$tag = uniqid( 'wp_phpunit' );
		\WP_PHPUnit::wp()->filter()->expect( $tag )->atMost()->twice();

		apply_filters( $tag, null );
		apply_filters( $tag, null );
		apply_filters( $tag, null );

		\Mockery::close();
	}

	public function testItCanWatchOnFilterWithSpecificArguments() {
		$tag   = uniqid( 'wp_phpunit' );
		$value = uniqid( 'correct_one_' );

		\WP_PHPUnit::wp()->filter()->expect( $tag )->with( $value )->atMost()->once();
		\WP_PHPUnit::wp()->filter()->expect( $tag )->with( $value );

		apply_filters( $tag, uniqid( 'other_' ) );
		apply_filters( $tag, $value );
		apply_filters( $tag, uniqid( 'other_' ) );

		\Mockery::close();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}