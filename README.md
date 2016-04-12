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

- Expect actions to occur via `\WP_PHPUnit::wp()->action( $tag )->expected()`.

Read more in the docs [docs/action.md].

## Core

- Mock or check for `wp_die()`.
  It won't ever disturb your testing.
- Check **redirects** if they occur
  and where they are going to via `\WP_PHPUnit::wp()->core()->expectWpRedirect()`.


Read more in the docs [doc/core.md].

## Filter

- **Disable** a filter
  so that it does not harm your tests.
- Make assertions on filter
  **how often** they are called
  and check for expected **arguments**.

Read more in [docs/filter.md].

## Options

- **Lock values** of a single option.
  Make them unchangeable during your test
  and/or return a specific value that you need.

Read more in [docs/options.md].
