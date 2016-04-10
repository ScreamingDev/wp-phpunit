<?php

namespace WP_PHPUnit\WordPress;

use WP_PHPUnit\Framework\Interceptor;

abstract class Abstract_Part {
	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getInterceptorMock() {
		return \Mockery::instanceMock(new Interceptor());
	}
}