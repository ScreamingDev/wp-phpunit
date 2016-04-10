<?php

namespace WP_PHPUnit\Tests\PHPUnit\WordPress\Filter;

class ExpectTest extends \PHPUnit_Framework_TestCase {
	public function testItCanWatchOnFilterWithSpecificArguments() {
		$tag   = uniqid( 'wp_phpunit' );
		$value = uniqid( 'correct_one_' );

		\WP_PHPUnit::wp()->filter( $tag )->expected()->with( $value )->atMost()->once();
		\WP_PHPUnit::wp()->filter( $tag )->expected()->with( $value );

		apply_filters( $tag, uniqid( 'other_' ) );
		apply_filters( $tag, $value );
		apply_filters( $tag, uniqid( 'other_' ) );

		\Mockery::close();
	}

	public function testItDoesNotHarmTheValue() {
		$filter = uniqid( 'wp_phpunit' );

		\WP_PHPUnit::wp()->filter( $filter )->expected();

		$before = uniqid();

		$after = apply_filters( $filter, $before );

		$this->assertSame( $before, $after );
	}

	public function testItRecognizesIfAnFilterHasRun() {
		$filter = uniqid( 'wp_phpunit' );

		\WP_PHPUnit::wp()->filter( $filter )->expected();

		apply_filters( $filter, null );

		\Mockery::close();
	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testItThrowsOutOfBoundsExceptionIfTheFilterHasNotRun() {
		$tag = uniqid( 'wp_phpunit' );

		\WP_PHPUnit::wp()->filter( $tag )->expected();

		\Mockery::close();

	}

	/**
	 * @expectedException \Mockery\Exception\InvalidCountException
	 */
	public function testTheAmountOfExpectedCallsCanBeChanged() {
		$tag = uniqid( 'wp_phpunit' );
		\WP_PHPUnit::wp()->filter( $tag )->expected()->times(3);

		apply_filters( $tag, null );
		apply_filters( $tag, null );

		\Mockery::close();
	}

	protected function tearDown() {
		\WP_PHPUnit::tearDown();
	}


}