<?php

use J7\Tests\Helper\User;



beforeAll(function () {
	User::instance();
});

beforeEach(function () {
		// User::instance();
});

afterEach(function () {
		// User::instance()->delete();
});

afterAll(function () {
	User::instance()->tear_down();
});

it('用戶角色為 [顧客]', function () {

		$user = User::instance()->user;
		expect($user)->not->toBeNull();
		expect($user->roles)->toContain('customer');
});

it('用戶 email 為 [test@example.com]', function () {
		$user = User::instance()->user;
		expect($user)->not->toBeNull();
		expect($user->user_email)->toEqual('test@example.com');
});