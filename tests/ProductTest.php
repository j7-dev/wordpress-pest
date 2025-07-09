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
	$products = Product::instance()->products;
	expect(count($products))->toBeGreaterThan(0);
	STDOUT::ok('商品創建成功');
});
