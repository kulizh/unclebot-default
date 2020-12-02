<?php
namespace Unclebot\Telegram;

use \Unclebot\Config;
use \Unclebot\Utils\Logger;

class Response
{
	private static $recipients = array();

	private static $method = '/sendMessage';

	public static function addChatId($chat_id)
	{
		array_push(self::$recipients, $chat_id);
	}

	public static function clearRecipients()
	{
		self::$recipients = array();
	}

	public static function setMethod($method)
	{
		self::$method = $method;
	}

	public static function send($data, $in_loop = false)
	{
		$postfields = $data;

		$config = Config::getInstance();
		$url = 'https://api.telegram.org/bot' . $config->telegram['bot_token'] . self::$method;

		foreach (self::$recipients as $chat_id)
		{
			$postfields['chat_id'] = $chat_id;
			
			Request::make($url, $postfields);
		}

		if (!$in_loop)
		{
			self::$recipients = array();
		}
	}

	public static function sendSingleMessage($data, $chat_id, $method = '/sendMessage')
	{
		$postfields = $data;
		$postfields['chat_id'] = $chat_id;

		$config = Config::getInstance();
		$url = 'https://api.telegram.org/bot' . $config->telegram['bot_token'] . $method;

		Request::make($url, $postfields);
	}
}
