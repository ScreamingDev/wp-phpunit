<?php

class WpTest extends PHPUnit_Framework_TestCase {
	public function testItOffersWpInstance() {
		$instance = new \WP_PHPUnit\Framework\TestCase();

		$this->assertInstanceOf( '\\WP_PHPUnit\\WordPress', $instance->wp() );
	}

	public function testItUsesTheSameInstanceOverAndOverAgain() {
		$first  = new \WP_PHPUnit\Framework\TestCase();
		$second = new \WP_PHPUnit\Framework\TestCase();

		$this->assertEquals( $first->wp(), $second->wp() );
	}
}