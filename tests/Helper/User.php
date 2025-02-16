<?php

declare(strict_types=1);

namespace J7\Tests\Helper;

use J7\Tests\Utils\STDOUT;

class User
{
	use \J7\WpUtils\Traits\SingletonTrait;

	public $user_id;

	public function __construct()
	{
		$this->create();
	}

	/**
	 * 創建 test 用戶
	 */
	public function create()
	{
		$user_data = [
			'role'         => 'customer',
			'user_login'   => 'test',
			'user_pass'    => 'test',
			'user_email'   => 'test@gmail.com',
		];

		// Check if user exists
		$user = get_user_by('login', $user_data['user_login']);

		if ($user) {
			$this->user_id = $user->ID;
			STDOUT::err('用戶已經存在: #' . $this->user_id);
			return;
		}

		$user_id_or_error = wp_insert_user($user_data);

		if (\is_wp_error($user_id_or_error)) {
			STDOUT::err('用戶創建失敗: ' . $user_id_or_error->get_error_message());
			throw new \Exception('User creation failed: ' . $user_id_or_error->get_error_message());
		} else {
			$this->user_id = $user_id_or_error;
			STDOUT::ok('用戶創建成功: #' . $this->user_id);
		}
	}

	/**
	 * 刪除 test 用戶
	 */
	public function delete()
	{
		\wp_delete_user($this->user_id);
	}
}
