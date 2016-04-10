<?php

class WpTest extends PHPUnit_Framework_TestCase {
	public function testItOffersWpInstance() {
		$instance = new \WP_PHPUnit\Framework\Test_Case();

		$this->assertInstanceOf( '\\WP_PHPUnit\\WordPress', $instance->wp() );
	}

	public function testItUsesTheSameInstanceOverAndOverAgain() {
		$first  = new \WP_PHPUnit\Framework\Test_Case();
		$second = new \WP_PHPUnit\Framework\Test_Case();

		$this->assertEquals( $first->wp(), $second->wp() );
	}
}