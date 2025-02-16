<?php

use J7\Tests\Helper\User;
use J7\Tests\Utils\STDOUT;

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
	User::instance()->delete();
});

it('用戶角色為 [顧客]', function () {

		$user = get_user_by('id', User::instance()->user_id);
		expect($user)->not->toBeNull();
		expect($user->roles)->toContain('customer');
});

it('用戶 email 為 [test@gmail.com]', function () {
		$user = get_user_by('id', User::instance()->user_id);
		expect($user)->not->toBeNull();
		expect($user->user_email)->toEqual('test@gmail.com');
});