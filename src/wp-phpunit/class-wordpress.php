<?php

namespace WP_PHPUnit;

use WP_PHPUnit\WordPress\Action;
use WP_PHPUnit\WordPress\Core;
use WP_PHPUnit\WordPress\Filter;

class WordPress {

	protected $_action;
	protected $_core;
	protected $_filter;

	public function __construct() {
		$this->_action = new Action();
		$this->_core   = new Core();
		$this->_filter = new Filter();
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

	public function reset() {
		$this->core()->reset();
		$this->filter()->reset();
		$this->action()->reset();
	}

	/**
	 * @return \WP_PHPUnit\WordPress\Action
	 */
	public function action() {
		return $this->_action;
	}
}