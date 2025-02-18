<?php

use J7\Tests\Helper\Order;
use J7\Tests\Helper\Product;
use J7\Tests\Utils\STDOUT;

beforeAll(function () {
	// 測試開始前執行
	Order::instance();
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
	Order::instance()->tear_down();
});

it('訂單創建成功', function () {
		$order = Order::instance()->order;
		$order->add_product(Product::instance()->simple_product, 2);
		$order->calculate_totals();

		$order->save();


		$total = $order->get_total();
		expect($total)->toEqual('200.00');
		STDOUT::ok('訂單總金額: ' . $total);

		expect($order->get_status())->toEqual('pending');
		STDOUT::ok('訂單狀態更新[待付款]成功');

		$order->set_status('completed');
		$order->save();

		expect($order->get_status())->toEqual('completed');
		STDOUT::ok('訂單狀態更新[已完成]成功');
});
