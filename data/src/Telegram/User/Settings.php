<?php
namespace Unclebot\Telegram\User;

use PDO;
use Unclebot\Utils\Database;

class Settings
{
    private PDO $db;
    private string $chatID;

    public function __construct(string $chat_id)
    {
        $this->db = Database::connect();
        $this->chatID = $chat_id;
    }

    public function set(string $alias, string $value)
    {
        if (!$this->settingAvailable($alias)) {
            return false;
        }

        $query = $this->db->prepare('
			INSERT INTO users_settings
				(user, setting, value)
			VALUES
				(?, ?, ?)
			ON DUPLICATE KEY UPDATE value = ?
		');
        $query->execute([$this->chatID, $alias, $value, $value]);

        return true;
    }

    public function getAll(): array {
        return $this->getSettings();
    }

    private function getSettings()
    {
        $settings = [];

        $query = $this->db->prepare('
            SELECT
                users_settings.value,
                settings.default_value,
                settings.alias
            FROM
                users_settings
                LEFT JOIN users ON users_settings.user = users.chat_id
                RIGHT JOIN settings ON users_settings.setting = settings.id
            WHERE
                users.chat_id = ?
		');
        $query->execute(array($this->chatID));

        while ($row = $query->fetch()) {
            $settings[$row['alias']] = array(
                'title' => $row['title'],
                'value' => (!empty($row['value'])) ? $row['value'] : $row['default_value'],
            );
        }

        return $settings;
    }

    private function settingAvailable(string $alias): bool
    {
        $query = $this->db->prepare('
			SELECT
				count(alias)
			FROM
				settings
			WHERE
				alias = ?
		');
        $query->execute(array($alias));

        return ($query->rowCount() > 0);
    }
}
