<?php

declare(strict_types=1);

namespace J7\Tests\Helper;

use J7\Tests\Utils\Log;
use J7\Tests\Utils\WC_UnitTestCase;

/**
 * Checkout class
 */
class Checkout extends WC_UnitTestCase
{
	use \J7\WpUtils\Traits\SingletonTrait;

	public $required_plugins = [
		'woocommerce/woocommerce.php',
		'powerhouse/plugin.php',
		'power-checkout/plugin.php'
	];

}
