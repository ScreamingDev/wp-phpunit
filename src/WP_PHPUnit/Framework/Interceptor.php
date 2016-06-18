<?php

namespace WP_PHPUnit\Framework;

class Interceptor {
	public function noop() {
		return;
	}

	public function passthrough( $value ) {
		return $value;
	}
}