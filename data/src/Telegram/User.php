<?php
namespace Unclebot\Telegram;

class User
{
	public $settings;

	public $state;

	private $db;

	private $chatID = '';

	private $nickname = '';

	private $name = '';

	private $surname = '';

	public function __construct(\PDO $db)
	{
		$this->db = $db;
	}

	public function getChatID() : string
	{
		return $this->chatID;
	}

	public function getNickname() : string
	{
		return $this->nickname;
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function getSurname() : string
	{
		return $this->surname;
	}

	public function register(string $chat_id, string $nickname = '', string $name = '', string $surname = ''): bool
	{
		$query = $this->db->prepare('
			INSERT INTO users
				(chat_id, nickname)
			VALUES
				(?, ?)
			ON DUPLICATE KEY UPDATE `status` = "active"
		');

		$this->chatID = $chat_id;
		$this->nickname = $nickname;
		$this->name = $name;
		$this->surname = $surname;

		$this->settings = new User\Settings($this->db, $chat_id);
		$this->state = new User\State($this->db, $chat_id);

		return $query->execute(array(
			$chat_id,
			$nickname
		));
	}
}