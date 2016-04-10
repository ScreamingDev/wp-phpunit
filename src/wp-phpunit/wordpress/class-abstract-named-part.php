<?php

namespace WP_PHPUnit\WordPress;

use WP_PHPUnit\Framework\Interceptor;

abstract class Abstract_Named_Part extends Abstract_Part {
	protected $_name;

	public function __construct( $identifier ) {
		$this->_name = $identifier;
	}

	public function getName() {
		return $this->_name;
	}
}