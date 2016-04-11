<?php

namespace WP_PHPUnit\Tests\PHPUnit\WordPress\Filter;

class DisableTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @backupGlobals
	 */
	public function testItCanDisableSingleCallable() {
		$name = uniqid( 'wp_phpunit' );
		add_filter( $name, '__return_false' );

		$this->assertFalse( apply_filters( $name, true ) );

		\WP_PHPUnit::wp()->filter( $name )->disable( '__return_false' );

		$this->assertTrue( apply_filters( $name, true ) );
	}

	public function testItCanDisableWholeFilter() {
		$tag = uniqid();

		$tmpFilter = \WP_PHPUnit::wp()->filter( $tag );

		$tmpFilter->add( '__return_null' );
		$tmpFilter->add( '__return_false' );
		$tmpFilter->add( '__return_true' );

		$this->assertTrue( apply_filters( $tag, 0 ) );

		\WP_PHPUnit::wp()->filter( $tag )->disable();

		$this->assertEquals( 0, apply_filters( $tag, 0 ) );

		$tmpFilter->reset();
	}

	public function testItRecoversTheFilterOnReset() {
		$tag = uniqid();

		$tmpFilter = \WP_PHPUnit::wp()->filter( $tag );

		$tmpFilter->add( '__return_null' );
		$tmpFilter->add( '__return_false' );
		$tmpFilter->add( '__return_true' );

		$this->assertTrue( apply_filters( $tag, 0 ) );

		\WP_PHPUnit::wp()->filter( $tag )->disable();

		$this->assertEquals( 0, apply_filters( $tag, 0 ) );

		$tmpFilter->reset();

		$this->assertTrue( apply_filters( $tag, 0 ) );

		// one more to check if everything is recovered within the correct order
		\WP_PHPUnit::wp()->filter( $tag )->disable( '__return_true' );

		$this->assertFalse( apply_filters( $tag, 0 ) );
	}

	/**
	 * @expectedException \OverflowException
	 */
	public function testItCanDisableCompleteFilterOnlyOnce() {
		$tag = uniqid();

		add_filter( $tag, '__return_null' );
		add_filter( $tag, '__return_false' );

		\WP_PHPUnit::wp()->filter( $tag )->disable();
		\WP_PHPUnit::wp()->filter( $tag )->disable();
	}

	/**
	 * @expectedException \OverflowException
	 */
	public function testItWontDisableCallableWhenCompleteFilterIsDisabled() {
		$tag = uniqid();

		add_filter( $tag, '__return_null' );
		add_filter( $tag, '__return_false' );

		\WP_PHPUnit::wp()->filter( $tag )->disable();
		\WP_PHPUnit::wp()->filter( $tag )->disable( '__return_null' );
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

	protected function tearDown() {
		parent::tearDown();

		\WP_PHPUnit::tearDown();
	}


}