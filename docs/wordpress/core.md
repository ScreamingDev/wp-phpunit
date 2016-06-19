# Core

## Check for `wp_die`

Disable or just check if `wp_die` has been used:

	\WP_PHPUnit::wp()->core()->expectWpDie();

## Check for redirects

Test if `wp_redirect` is used:

	\WP_PHPUnit::wp()->core()->expectWpRedirect();

You can check for specific arguments:

	// A location and some status
	\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( 'http://example.org', anything() );
	
	// Any location and a specific status
	\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( anything(), 303 );
	
	// Or a specific location and status exactly once
	\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( 'http://example.org', 303 )->times(1);
