<?php
namespace Unclebot\Telegram;

use Unclebot\Telegram\Helpers\Gate;
use Unclebot\Telegram\Helpers\Templator;
use Unclebot\Telegram\Models\ReplyMarkup\ReplyKeyboard;
use \Unclebot\Telegram\Models\Text as TelegramText;

class Commands
{
    private User $user;
    private string $command;
    private ResponseText $responseText;

    public function __construct(User $user, string $command, ResponseText $responseText)
    {
        $this->user = $user;
        $this->command = ltrim($command, '/');
        $this->responseText = $responseText;
    }

    public function getResponseData()
    {
        $command = $this->command;

        if (Gate::adminArea($command)) {
            $forbidden = Gate::forbid($this->user);

            if (!empty($forbidden)) {
                return $forbidden;
            }
        }

        switch ($command) {
            default:
                return array();
            case 'start':
                return $this->start();
        }
    }

    private function start()
    {
        $text = $this->responseText->get('start');

        $telegramTextModel = new TelegramText($text);
        $telegramTextModel->removeKeyboard();

        return $telegramTextModel->getData();
    }
}
