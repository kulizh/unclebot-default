<?php
namespace Unclebot\Telegram;

use Unclebot\Telegram\Models\Text as TelegramText;

class Broadcast
{
    public static function admin(string $message)
    {
        $telegramTextModel = new TelegramText($message);
        $telegramTextModel->removeKeyboard();

        Response::sendSingleMessage($telegramTextModel->getData(), User::CREATOR_CHAT_ID);
    }

    public static function everyone(array $chat_ids, string $message) 
    {
        $telegramTextModel = new TelegramText($message);
        $telegramTextModel->removeKeyboard();

        foreach($chat_ids as $id) {
            Response::addChatId($id);
        }

        Response::send($telegramTextModel->getData());
    }
}
