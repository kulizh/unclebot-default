<?php
namespace Unclebot\Telegram;

use \Unclebot\Config;
use \Unclebot\Exceptions\RequestException;

class Request
{
	public static function make($url, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);

		if (!empty($data))
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
		}

		$result = curl_exec($ch);

		if (empty($result) || !empty(curl_errno($ch)))
		{
			$msg = curl_errno($ch) . ' — ' . curl_error($ch);
			throw new RequestException($msg, 500);
		}

		curl_close($ch);
	}
}
