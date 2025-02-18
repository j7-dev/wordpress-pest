<?php

declare(strict_types=1);

namespace J7\Tests\Helper;

use J7\Tests\Utils\Log;

/**
 * Checkout class
 */
class Checkout extends \WP_UnitTestCase
{
	use \J7\WpUtils\Traits\SingletonTrait;


	public function __construct()
	{
		\add_action('plugins_loaded', [$this, 'required_plugins'], -1);
		\add_action('init', [$this, 'create']);

		\do_action('plugins_loaded');
		\do_action('init');
	}

	public function required_plugins()
	{
		$required_plugins = [
			'woocommerce/woocommerce.php'
		];
		foreach ($required_plugins as $plugin) {
			require_once PLUGIN_DIR . $plugin;
		}
	}

	/**
	 * 創建 簡單、可變 產品
	 */
	public function create()
	{
	}

}
