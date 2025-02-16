<?php

use J7\Tests\Helper\Product;
use J7\Tests\Utils\STDOUT;

beforeAll(function () {
	// 測試開始前執行
	Product::instance();
});

beforeEach(function () {
	// 每次測試前執行
});

afterEach(function () {
	// 每次測試後執行
});

afterAll(function () {
	// 測試結束後執行
	Product::instance()->tear_down();
});

it('商品創建成功', function () {
		$simple_product = Product::instance()->simple_product;
		expect($simple_product->get_type())->toEqual('simple');
		STDOUT::ok('簡單商品創建成功');

		$variable_product = Product::instance()->variable_product;
		expect($variable_product->get_type())->toEqual('variable');
		// 至少有一個變體
		expect($variable_product->get_children())->toBeGreaterThanOrEqual(1);
		STDOUT::ok('可變商品創建成功，至少有一個變體');
});
