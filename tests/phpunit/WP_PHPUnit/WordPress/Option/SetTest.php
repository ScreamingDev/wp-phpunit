<?php

namespace WP_PHPUnit\Tests\PHPUnit\WordPress\Option;


class SetTest extends \PHPUnit_Framework_TestCase {
	public function testItNoLongerForceAValueAfterResetting() {
		$option = uniqid();
		$value  = uniqid();

		$this->assertNotEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->set( $value );

		$this->assertEquals( $value, get_option( $option ) );
	}

	public function testItPersistTheValueOfAnOption() {
		$option = uniqid();
		$value  = uniqid();

		$this->assertNotEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->option( $option )->set( $value );

		$this->assertEquals( $value, get_option( $option ) );

		\WP_PHPUnit::wp()->reset();

		$this->assertNotEquals( $value, get_option( $option ) );
	}

	protected function tearDown() {
		parent::tearDown();

		\WP_PHPUnit::tearDown();
	}


}