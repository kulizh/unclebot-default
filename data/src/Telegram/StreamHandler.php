<?php
namespace Unclebot\Telegram;

use Unclebot\Utils\Logger;

class StreamHandler
{
    private $stream;

    public function __construct()
    {
        $this->decodeStream();
    }

    public function handle()
    {
        $stream = $this->stream;

        if (empty($stream['message'])) {
            return;
        }

        $chat_id = $stream['message']['from']['id'] ?? 0;

        if (empty($chat_id)) {
            throw new \Exception('Empty chat_id: ' . json_encode($stream));
        }

        $message = $stream['message']['text'];

        $username = $stream['message']['from']['username'] ?? '';
        $name = $stream['message']['from']['first_name'] ?? '';

        $user = new User($chat_id, [
            'username' => $username,
            'name' => $name,
        ]);

        $responseText = new ResponseText();

        Response::addChatId($chat_id);

        $message = $this->commandAlias($message);

        if ($message[0] === '/') {
            $commands = new Commands($user, $message, $responseText);
            $response = $commands->getResponseData();
        } else {
            $stateMachine = new StateMachine($user, $message, $responseText);
            $response = $stateMachine->handle();
        }

        if (empty($response)) {
            $response = ['text' => $responseText->get('default')];
        }

        if (!empty($response[0])) {
            foreach ($response as $item) {
                if (!empty($item['text']) && !empty($item['timeout'])) {
                    Response::send($item['text'], true);
                    sleep($item['timeout']);
                } else {
                    Response::send($item, true);
                    sleep(1);
                }
            }

            Response::clearRecipients();
        } else {
            Response::send($response);
        }
    }

    private function decodeStream()
    {
        $stream_encoded = file_get_contents('php://input');
        $this->stream = json_decode($stream_encoded, true);

        $logger = new Logger('telegram_input_stream');
        $logger->write($stream_encoded);
    }

    private function commandAlias($text)
    {
        return $text;
    }
}
