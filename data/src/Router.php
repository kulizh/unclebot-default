<?php
namespace Unclebot;

use \Unclebot\Server\Response;
use \Unclebot\Utils\Database;
use \Unclebot\Telegram\Request as TelegramRequest;

class Router
{
    private $request;

    private $config;

    private $db;

    public function __construct()
    {
        $this->request = Server\Request::getInstance();
        $this->config = Config::getInstance();
		$this->db = Database::connect($this->config->db);
    }

    public function handle()
    {
        $request_data = $this->request->getData();
     	$request_query = $this->request->getQuery();

        if (isset($request_data['register']))
		{
			$this->register($request_data['register']);
		}
        elseif ($request_query === 'get')
		{
			$this->telegramStreamHandle();
		}
        else
		{
			Response::error(403);
		}
    }

    private function telegramStreamHandle()
	{
		$handler = new Telegram\StreamHandler($this->db);
		return $handler->handle();
	}

    private function register($register_key)
	{
		if (empty($register_key))
		{
			Response::error(400);
		}

		if ($register_key !== $this->config->telegram['register_key'])
		{
			Response::error(403);
		}

		$url = 'https://api.telegram.org/bot' . $this->config->telegram['bot_token'] . '/setWebhook?url=';
		$url .= $this->config->telegram['bot_rest_url'];

		TelegramRequest::make($url, array());
	}
}
