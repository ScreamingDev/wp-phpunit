<?php

namespace WP_PHPUnit\Tests\PHPUnit\WordPress\Option;


class LockTest extends \PHPUnit_Framework_TestCase {
	public function testItNoLongerLockTheValueAfterResetting() {
		$option = uniqid();
		$value  = uniqid();

		$this->assertNotEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->set( $value );

		$this->assertEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->reset();

		$this->assertNotEquals( $value, get_option( $option ) );
	}

	public function testLockedOptionsCanNotBeChanged() {
		$option  = 'site_url';
		$siteUrl = get_option( $option );

		\WP_PHPUnit::wp()->option( $option )->lock();

		update_option( $option, uniqid() );

		$this->assertEquals( $siteUrl, get_option( $option ) );
	}

	protected function tearDown() {
		parent::tearDown();

		\WP_PHPUnit::tearDown();
	}


}