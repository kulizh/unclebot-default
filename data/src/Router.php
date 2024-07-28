<?php
namespace Unclebot;

use Unclebot\Server\Response;
use Unclebot\Server\Request;
use Unclebot\Telegram\StreamHandler;
use Unclebot\Telegram\Request as TelegramRequest;

class Router
{
    private Request $request;
    private Config $config;

    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->config = Config::getInstance();
    }

    public function handle(): void
    {
        $request_data = $this->request->getData();
        $request_query = $this->request->getQuery();

        if (isset($request_data['register'])) {
            $this->register($request_data['register']);
        } elseif ($request_query === 'get') {
            $this->telegramStreamHandle();
        } else {
            Response::error(403);
        }
    }

    private function telegramStreamHandle(): void
    {
        (new StreamHandler())->handle();
    }

    private function register($register_key): void
    {
        if (empty($register_key)) {
            Response::error(400);
        }

        if ($register_key !== $this->config->telegram['register_key']) {
            Response::error(403);
        }

        $url = 'https://api.telegram.org/bot' . $this->config->telegram['bot_token'] . '/setWebhook?url=';
        $url .= $this->config->telegram['bot_rest_url'];

        TelegramRequest::make($url);
    }
}
