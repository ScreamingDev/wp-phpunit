<?php

namespace WP_PHPUnit\Tests\PHPUnit\WordPress\Option;


class LockTest extends \PHPUnit_Framework_TestCase {
	public function testItNoLongerLockTheValueAfterResetting() {
		$option = uniqid();
		$value  = uniqid();

		$this->assertNotEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->lockValue( $value );

		$this->assertEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->reset();

		$this->assertNotEquals( $value, get_option( $option ) );
	}

	public function testLockedOptionsCanNotBeChanged() {
		$option  = 'site_url';
		$siteUrl = get_option( $option );

		\WP_PHPUnit::wp()->option( $option )->lockValue();

		update_option( $option, uniqid() );

		$this->assertEquals( $siteUrl, get_option( $option ) );
	}

	public function testOtherOptionsAreNotHarmed() {
		$option      = uniqid();
		$value       = uniqid();
		$otherOption = uniqid();
		$otherValue  = uniqid();

		$this->assertNotEquals( $value, get_option( $option ) );

		update_option( $option, $value );

		\WP_PHPUnit::wp()->option( $option )->lockValue();

		update_option( $option, uniqid() );

		$this->assertEquals( $value, get_option( $option ) );

		update_option( $otherOption, $otherValue );

		$this->assertNotEquals( $value, get_option( $otherOption ) );
		$this->assertEquals( $otherValue, get_option( $otherOption ) );
	}

	public function testItNoLongerForceAValueAfterResetting() {
		$option = uniqid();
		$value  = uniqid();

		$this->assertNotEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->lockValue( $value );

		$this->assertEquals( $value, get_option( $option ) );
	}

	public function testItPersistTheValueOfAnOption() {
		$option = uniqid();
		$value  = uniqid();

		$this->assertNotEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->lockValue( $value );

		$this->assertEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->reset();

		$this->assertNotEquals( $value, get_option( $option ) );
	}

	protected function tearDown() {
		parent::tearDown();

		\WP_PHPUnit::tearDown();
	}


}