<?php
namespace Unclebot\Telegram;

use PDO;
use Unclebot\Telegram\User\Settings;
use Unclebot\Telegram\User\State;
use Unclebot\Utils\Database;

class User
{
    const CREATOR_CHAT_ID = 74705134;
    const ADMIN_CHAT_IDS = [
        74705134, // @kulizh
    ];

    public Settings $settings;
    public State $state;
    private PDO $db;

    private string $username;
    private string $chatID;

    public static function all(string $query = ''): array {
        $db = Database::connect();

        $query = $db->prepare('
            SELECT
                chat_id
            FROM
                users
            WHERE
                status = "active"
        ' . $query);
        $query->execute();

        $chat_ids = [];

        while($row = $query->fetch()) {
            $chat_ids[] = $row['chat_id'];
        }

        return $chat_ids;
    }

    public static function last(): array {
        $db = Database::connect();

        $query = $db->prepare('
            SELECT
                *
            FROM
                users
            WHERE
                status = "active"
            ORDER BY
                created_at DESC
            LIMIT 1
        ');
        $query->execute();

        return $query->fetch() ?? [];
    }

    public function __construct(string $id, array $user_info = [])
    {
        $this->db = Database::connect();

        $this->register(
            $id,
            $user_info['username'] ?? '',
        );

        $this->settings = new Settings($id);
        $this->state = new State($id);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getChatId(): string
    {
        return $this->chatID;
    }

    public function isAdmin(): bool {
        return in_array($this->chatID, self::ADMIN_CHAT_IDS);
    }

    private function register(string $chat_id, string $nickname = '', string $name = '', string $surname = ''): bool
    {
        $this->username = $nickname;
        $this->chatID = $chat_id;

        $query = $this->db->prepare('
			INSERT INTO users
				(chat_id, nickname, name, surname)
			VALUES
				(?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE `status` = "active"
		');

        return $query->execute([
            $chat_id, $nickname, $name, $surname
        ]);
    }
}
