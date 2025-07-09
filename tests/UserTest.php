<?php

use J7\Tests\Helper\User;

beforeAll(function () {
	// 測試開始前執行
	User::instance();
});

beforeEach(function () {
	// 每次測試前執行
});

afterEach(function () {
	// 每次測試後執行
});

afterAll(function () {
	// 測試結束後執行
	User::instance()->tear_down();
});

it('用戶角色為 [顧客]', function () {

		$user = User::instance()->user;
		expect($user)->not->toBeNull();
		expect($user->roles)->toContain('customer');
});

it('用戶 email 為 [testtest@example.com]', function () {
		$user = User::instance()->user;
		expect($user)->not->toBeNull();
		expect($user->user_email)->toEqual('testtest@example.com');
});