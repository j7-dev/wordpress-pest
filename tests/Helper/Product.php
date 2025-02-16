<?php

declare(strict_types=1);

namespace J7\Tests\Helper;

use J7\Tests\Utils\Log;

/**
 * User class
 * 1. 實例化 Product 類別時，會自動創建 簡單、可變、訂閱、可變訂閱 產品
 * 2. 有 create 跟 delete 方法
 * TODO 支援組合、外部商品
 */
class Product extends \WP_UnitTestCase
{
	use \J7\WpUtils\Traits\SingletonTrait;

	/** @var \WC_Product_Simple */
	public $simple_product;

	/** @var \WC_Product_Variable */
	public $variable_product;

	/** @var \WC_Product_Subscription */
	public $subscription_product;

	/** @var \WC_Product_Variable_Subscription */
	public $variable_subscription_product;

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
		$this->create_simple();
		$this->create_variable();
	}

	/**
	 * 創建 簡單 產品
	 */
	public function create_simple()
	{
		// 創建簡單商品
		$product = new \WC_Product_Simple();
		$product->set_name('測試簡單商品');
		$product->set_regular_price('100');
		$product->set_description('這是一個測試用的簡單商品');
		$product->set_short_description('簡短描述');
		$product->set_status('publish');
		$product->save();

		// 將創建的商品存入 simple_product 屬性
		$this->simple_product = $product;
	}

	/**
	 * 創建 可變 產品
	 */
	public function create_variable() {
		// 創建可變商品
		$product = new \WC_Product_Variable();
		$product->set_name('測試可變商品');
		$product->set_description('這是一個測試用的可變商品');
		$product->set_short_description('簡短描述');
		$product->set_status('publish');
		$product->save();

		// 創建商品屬性
		$attribute = new \WC_Product_Attribute();
		$attribute->set_name('尺寸'); // 屬性名稱
		$attribute->set_options(['S', 'M', 'L']); // 屬性選項
		$attribute->set_position(0);
		$attribute->set_visible(true);
		$attribute->set_variation(true);

		$product->set_attributes(array($attribute));
		$product->save();

		// 創建商品變體
		$variation_data = array(
			array(
				'attributes' => array(
					'尺寸' => 'S'
				),
				'regular_price' => '100',
				'sku' => 'VAR-S'
			),
			array(
				'attributes' => array(
					'尺寸' => 'M'
				),
				'regular_price' => '120',
				'sku' => 'VAR-M'
			),
			array(
				'attributes' => array(
					'尺寸' => 'L'
				),
				'regular_price' => '140',
				'sku' => 'VAR-L'
			)
		);

		foreach ($variation_data as $variation) {
			$new_variation = new \WC_Product_Variation();
			$new_variation->set_parent_id($product->get_id());
			$new_variation->set_attributes($variation['attributes']);
			$new_variation->set_regular_price($variation['regular_price']);
			$new_variation->set_sku($variation['sku']);
			$new_variation->set_status('publish');
			$new_variation->save();
		}

		// 重新讀取產品資料，確保能獲取到最新的變體資訊
		$product = wc_get_product($product->get_id());

		// 將創建的商品存入 variable_product 屬性
		$this->variable_product = $product;
	}

	/**
	 * 創建 訂閱 產品
	 */
	public function create_subscription() {}

	/**
	 * 創建 可變訂閱 產品
	 */
	public function create_variable_subscription() {}

	/**
	 * 測試結束後 刪除所有商品
	 */
	public function tear_down()
	{
		parent::tear_down();

		// 刪除所有商品
		$this->simple_product->delete(true);

		$variation_product_ids = $this->variable_product->get_children();

		foreach ($variation_product_ids as $variation_product_id) {
			$variation_product = \wc_get_product($variation_product_id);
			$variation_product?->delete(true);
		}
		$this->variable_product->delete(true);
	}
}
