<?php

namespace WP_PHPUnit\WordPress;

abstract class AbstractNamedPart extends AbstractPart {
	protected $_name;

	public function __construct( $identifier ) {
		$this->_name = $identifier;
	}

	public function getName() {
		return $this->_name;
	}
}