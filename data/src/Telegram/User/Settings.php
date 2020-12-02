<?php
namespace Unclebot\Telegram\User;

class Settings
{
	private $db;

	private $settings;

	private $chatID;

	public function __construct(\PDO $db, string $chatID)
	{
		$this->db = $db;
		$this->chatID = $chatID;

		$this->settings = $this->getSettings($chatID);
	}

	public function get()
	{
		return $this->settings;
	}

	public function set(string $alias, $value)
	{
		if (!$this->settingExists($alias))
		{
			return false;
		}

		$query = $this->db->prepare('
			INSERT INTO users_settings
				(user, setting, value)
			VALUES 
				(?, ?, ?)
			ON DUPLICATE KEY UPDATE value = ?
		');
		$query->execute(array($this->chatID, $alias, $value, $value));

		return true;
	}

	private function getSettings(string $chat_id)
	{
		$settings = [];

		$query = $this->db->prepare('
			SELECT 
				settings.alias, 
				settings.title, 
				settings.default_value, 
				(SELECT 
					`value` 
				FROM 
					users_settings 
				WHERE 
					users_settings.setting = settings.alias 
				AND 
					users_settings.user = 74705134) as value 
			FROM 
				settings 
		');
		$query->execute(array($chat_id));

		while ($row = $query->fetch())
		{
			$settings[$row['alias']] = array(
				'title' => $row['title'],
				'value' => (!empty($row['value'])) ? $row['value'] : $row['default_value']
			);
		}

		return $settings;
	}

	private function settingExists(string $alias) : bool
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