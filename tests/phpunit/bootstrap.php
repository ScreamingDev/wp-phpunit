<?php

require_once __DIR__ . '/../../vendor/autoload.php';

// find wp-load
$wpBase = __DIR__;

while ( dirname( $wpBase ) != $wpBase ) {
	$wpBase = dirname( $wpBase );

	if ( file_exists( $wpBase . '/wp-load.php' ) ) {
		break;
	}
}

require_once $wpBase . '/wp-load.php';


