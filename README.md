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

	\WP_PHPUnit::wp()->action()->expect( $tag );

Or a bit more detailled:

	// expect it not more than once
	\WP_PHPUnit::wp()->action()->expect( $tag )->atMost()->once();
    
	// expect the action with specific values
	\WP_PHPUnit::wp()->action()->expect( $tag )->with( [ 'value1', 'value2' ] );

	// or both
	\WP_PHPUnit::wp()->action()->expect( $tag )->with( [ 'value1', 'value2' ] )->atMost()->once();

## Core

### Check for `wp_die`

	\WP_PHPUnit::wp()->core()->expectWpDie();

## Filter

Assert the execution of filter:

	\WP_PHPUnit::wp()->filter()->expect( $tag );

Or a bit more detailled:

	// expect it not more than once
	\WP_PHPUnit::wp()->filter()->expect( $tag )->atMost()->once();
    
	// expect the filter with specific values
	\WP_PHPUnit::wp()->filter()->expect( $tag )->with( 'value1' );

	// or both
	\WP_PHPUnit::wp()->filter()->expect( $tag )->with( 'value1' )->atMost()->once();
