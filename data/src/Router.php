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
        $request_method = $this->request->getRequestMethod();

        switch ($request_method)
		{
			case 'register':
				$this->register();
			break;
			case
				$this->telegramStreamHandle();
			break;
			default:
				Response::error(400);
		}

		Response::success();
    }

    private function telegramStreamHandle()
	{
		$handler = new Telegram\StreamHandler($this->db);
		return $handler->handle();
	}

    private function register()
	{
		$params = $this->request->getRequestParams();

		if (empty($params[0]) || ($params[0] !== $this->config->telegram['register_key']))
		{
			Response::error(403);
		}

		$url = 'https://api.telegram.org/bot' . $this->config->telegram['bot_token'] . '/setWebhook?url=';
		$url .= $this->config->telegram['bot_rest_url'];

		TelegramRequest::make($url, array());
	}
}
