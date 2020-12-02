<?php
namespace Unclebot\Telegram;

use \Unclebot\Utils\Logger;

class StreamHandler
{
	private $stream;

	private $db;

	public function __construct(\PDO $db)
	{
		$this->db = $db;
		$this->decodeStream();
	}

	public function handle()
	{
		$stream = $this->stream;

		$chat_id = $stream['message']['from']['id'];
		$message = $stream['message']['text'];

		$nickname = $stream['message']['from']['username'] ?? '';
		$name = $stream['message']['from']['first_name'] ?? '';

		$user = new User($this->db);
		$user->register($chat_id, $nickname, $name);

		$responseText = new ResponseText($this->db);

		Response::addChatId($chat_id);

		$response_default = array(
			'text' => $responseText->get('default'),
		);

		$message = $this->commandAlias($message);

		if ($message[0] === '/')
		{
			$commands = new Commands($user, $message, $responseText);
			$response = $commands->getResponseData();
		}
		else
		{
			$stateMachine = new StateMachine($user, $message, $responseText);
			$response = $stateMachine->handle();
		}

		if (empty($response))
		{
			$response = $response_default;
		}

		if (!empty($response[0]))
		{
			foreach ($response as $item)
			{
				if (!empty($item['text']) && !empty($item['timeout']))
				{
					Response::send($item['text'], true);
					sleep($item['timeout']);
				}
				else
				{
					Response::send($item, true);
					sleep(1);
				}
			}

			Response::clearRecipients();
		}
		else
		{
			Response::send($response);
		}
	}

	private function decodeStream()
	{
		$stream_encoded = file_get_contents('php://input');

		$this->stream = json_decode($stream_encoded, true);

		$logger = new Logger('telegram_input_stream');
		$logger->write(print_r($this->stream, true));
	}

	private function commandAlias($text)
	{
		return $text;
	}
}
