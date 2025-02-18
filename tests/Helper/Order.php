<?php

declare(strict_types=1);

namespace J7\Tests\Helper;

use J7\Tests\Utils\Log;

/**
 * Order class
 * 1. 實例化 Order 類別時，會自動創建訂單
 * 2. 有 create 跟 add 方法
 * @see https://rudrastyh.com/woocommerce/create-orders-programmatically.html
 */
class Order extends \WP_UnitTestCase
{
	use \J7\WpUtils\Traits\SingletonTrait;

	/** @var \WC_Order */
	public $order;

	public function __construct()
	{
		\add_action('plugins_loaded', [$this, 'required_plugins'], -1);
		\add_action('init', [$this, 'create']);


		\do_action('plugins_loaded');
		\do_action('after_setup_theme');
		\do_action('init');
		\do_action('wp_loaded');
		\do_action('parse_request');
		\do_action('send_headers');
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
	 * 創建訂單
	 * @param array{
	 * status?: string,
	 * customer_id?: int,
	 * customer_note?: string,
	 * parent?: int,
	 * order_id?: int,
	 * created_via: "admin", "checkout", "store-api",
	 * card_hash?: string,
	 * } $args
	 *
	 * @return void
	 */
	public function create($args = []):void
	{
		$default_args = array(
			'status' => 'pending', // 等待付款中
			'created_via' => 'admin', // default values are "admin", "checkout", "store-api"
			'order_id' => 0, // 新建立訂單
			'customer_id' => 1, // 客戶ID
		);

		/**
		 * @var array{
		 * status?: string,
		 * customer_id?: int,
		 * customer_note?: string,
		 * parent?: int,
		 * order_id?: int,
		 * created_via: "admin", "checkout", "store-api",
		 * card_hash?: string,
		 * } $args
		 */
		$args = \wp_parse_args($args, $default_args);
		$this->order = \wc_create_order( $args );
	}

		/**
	 * 測試結束後 刪除訂單
	 */
	public function tear_down()
	{
		parent::tear_down();
		$this->order->delete(true);
	}
}
