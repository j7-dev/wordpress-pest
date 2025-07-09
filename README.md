# WordPress Unit Test integrate with Pest

This project is forked from [wordpress-test-plugin](https://github.com/adeleyeayodeji/wordpress-test-plugin)

## References

https://make.wordpress.org/core/handbook/testing/automated-testing/writing-phpunit-tests/

https://pestphp.com/

## Factories

```php
// Create a user
$user = WP_UnitTestCase::factory()->user->create();

// Create a post
$post = WP_UnitTestCase::factory()->post->create();

// Create a comment
$comment = WP_UnitTestCase::factory()->comment->create();

```

see more at wp-phpunit/includes/factory/
