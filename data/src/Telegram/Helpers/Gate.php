<?php
namespace Unclebot\Telegram\Helpers;

use Unclebot\Telegram\User;
use Unclebot\Telegram\Models\Text as TelegramText;

class Gate
{
    private static $ADMIN_COMMANDS = [
        'broadcast',
    ];

    public static function adminArea(string $command): bool
    {
        return in_array($command, self::$ADMIN_COMMANDS);
    }

    public static function forbid(User $user): array {
        if ($user->isAdmin()) {
            return [];
        }

        $telegramTextModel = new TelegramText('Нет доступа');
        $telegramTextModel->removeKeyboard();
        $user->state->clear();

        return $telegramTextModel->getData();
    }
}
