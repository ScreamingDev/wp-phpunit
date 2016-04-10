<?php

require_once __DIR__ . '/wp-phpunit/class-wordpress-autoloader.php';

\WP_PHPUnit\WordPress_Autoload::register_directory(__DIR__);

spl_autoload_register( array( new \WP_PHPUnit\WordPress_Autoload(), 'load_class' ) );