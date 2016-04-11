# WP PHPUnit

Get it:

	composer require sourcerer-mike/wp-phpunit:dev-master

Might be renamed with the first major release.

But please remember to tearDown it after each test:

	class Test_Case extends \PHPUnit_Framework_TestCase {
		protected function tearDown() {
			\WP_PHPUnit::tearDown();
		}
	}

or reset everything to have a clean environment

	\WP_PHPUnit::wp()->reset();

This supports:

- WordPress 4.0 to 4.5
- PHP 5.5 to 7.0
- Due to wp-cli HHVM can not be tested yet :(

## Actions

### Expect actions

Write your test and assert the execution of actions:

	\WP_PHPUnit::wp()->action( $tag )->expected();

Or a bit more detailled:

	// expect it not more than once
	\WP_PHPUnit::wp()->action( $tag )->expected()->atMost()->once();
    
	// expect the action with specific values
	\WP_PHPUnit::wp()->action( $tag )->expected()->with( [ 'value1', 'value2' ] );

	// or both
	\WP_PHPUnit::wp()->action( $tag )->expected()->with( [ 'value1', 'value2' ] )->atMost()->once();

## Core

### Check for `wp_die`

Disable or just check if `wp_die` has been used:

	\WP_PHPUnit::wp()->core()->expectWpDie();

### Check for redirects

Test if `wp_redirect` is used:

	\WP_PHPUnit::wp()->core()->expectWpRedirect();

You can check for specific arguments:

	// A location and some status
	\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( 'http://example.org', anything() );
	
	// Any location and a specific status
	\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( anything(), 303 );
	
	// Or a specific location and status exactly once
	\WP_PHPUnit::wp()->core()->expectWpRedirect()->with( 'http://example.org', 303 )->times(1);

## Filter

### Assertion on filter

Expect the execution of a filter:

	\WP_PHPUnit::wp()->filter( $tag )->expected();

Or a bit more detailled:

	// expect it not more than once
	\WP_PHPUnit::wp()->filter( $tag )->expected()->atMost()->once();
    
	// expect the filter with specific values
	\WP_PHPUnit::wp()->filter( $tag )->expected()->with( 'value1' );

	// or both
	\WP_PHPUnit::wp()->filter( $tag )->expected()->with( 'value1' )->atMost()->once();

### Disable filter

When a filter disturbs your testing then disable it for this particular test:

	\WP_PHPUnit::wp()->filter( $tag )->disable();

Or just a specific function using:

	\WP_PHPUnit::wp()->filter( $tag )->disable( $callable );

Complete filters can be removed only once during a test-method.
Removed filter will be recovered during `\WP_PHPUnit::tearDown()`.

## Options

### Freeze values

Make an option unchangeable

	// Keep the value
	\WP_PHPUnit::wp()->option( $tag )->lockValue();
	
	// or have one for the whole test
	\WP_PHPUnit::wp()->option( $tag )->lockValue( $value );
