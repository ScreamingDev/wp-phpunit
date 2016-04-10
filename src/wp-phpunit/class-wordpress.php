<?php

namespace WP_PHPUnit;

use WP_PHPUnit\WordPress\Abstract_Part;
use WP_PHPUnit\WordPress\Action;
use WP_PHPUnit\WordPress\Core;
use WP_PHPUnit\WordPress\Filter;

class WordPress {

	protected $_core;
	protected $_filter;
	protected $_parts;

	public function __construct() {
		$this->_core   = new Core();
		$this->_filter = new Filter();
	}

	/**
	 * @return \WP_PHPUnit\WordPress\Action
	 */
	public function action( $identifier ) {
		$action         = new Action( $identifier );
		$this->_parts[] = $action;

		return $action;
	}

	public function reset() {
		$this->core()->reset();
		$this->filter()->reset();

		foreach ( $this->_parts as $part ) {
			/** @var Abstract_Part $part */
			$part->reset();
		}
	}

	/**
	 * @return Core
	 */
	public function core() {
		return $this->_core;
	}

	/**
	 * @return Filter
	 */
	public function filter() {
		return $this->_filter;
	}
}