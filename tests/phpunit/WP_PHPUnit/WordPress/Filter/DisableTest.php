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

		\WP_PHPUnit::wp()->filter( $name )->disable( '__return_false' );

		$this->assertTrue( apply_filters( $name, true ) );
	}

	/**
	 * @backupGlobals
	 */
	public function testItRecoversFilterAfterReset() {
		$name = uniqid( 'wp_phpunit' );
		add_filter( $name, '__return_false' );

		$this->assertFalse( apply_filters( $name, true ) );

		\WP_PHPUnit::wp()->filter( $name )->disable( '__return_false' );

		$this->assertTrue( apply_filters( $name, true ) );

		\WP_PHPUnit::wp()->reset();

		$this->assertFalse( apply_filters( $name, true ) );
	}

	public function testItThrowsNoExceptionWhenFilterDoesNotExist() {
		\WP_PHPUnit::wp()->filter( uniqid() )->disable( '__return_false' );
	}

	/**
	 * @backupGlobals
	 */
	public function testItThrowsNoExceptionWhenFunctionDoesNotExist() {
		$tag = uniqid();

		add_filter( $tag, '__return_false' );

		\WP_PHPUnit::wp()->filter( $tag )->disable( uniqid( 'wp_phpunit' ) );
	}
}