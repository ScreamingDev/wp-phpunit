<?php

namespace WP_PHPUnit\Tests\PHPUnit\WordPress\Filter;

class DisableTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @backupGlobals
	 */
	public function testItCanDisableAFilter() {
		$name = uniqid( 'wp_phpunit' );
		add_filter( $name, '__return_false' );

		$this->assertFalse( apply_filters( $name, true ) );

		\WP_PHPUnit::wp()->filter()->disable( $name, '__return_false' );

		$this->assertTrue( apply_filters( $name, true ) );
	}

	/**
	 * @backupGlobals
	 */
	public function testItRecoversFilterAfterReset() {
		$name = uniqid( 'wp_phpunit' );
		add_filter( $name, '__return_false' );

		$this->assertFalse( apply_filters( $name, true ) );

		\WP_PHPUnit::wp()->filter()->disable( $name, '__return_false' );

		$this->assertTrue( apply_filters( $name, true ) );

		\WP_PHPUnit::wp()->filter()->reset();

		$this->assertFalse( apply_filters( $name, true ) );
	}

	public function testItThrowsNoExceptionWhenFilterDoesNotExist() {
		\WP_PHPUnit::wp()->filter()->disable( uniqid(), '__return_false' );
	}

	/**
	 * @backupGlobals
	 */
	public function testItThrowsNoExceptionWhenFunctionDoesNotExist() {
		$tag = uniqid();

		add_filter( $tag, '__return_false' );

		\WP_PHPUnit::wp()->filter()->disable( uniqid(), uniqid( 'wp_phpunit' ) );
	}
}