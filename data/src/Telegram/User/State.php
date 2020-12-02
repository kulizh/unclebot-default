<?php
namespace Unclebot\Telegram\User;

class State
{
	private $db;

	private $state = '';

	private $chatID = '';

	public function __construct(\PDO $db, string $chatID)
	{
		$this->db = $db;
		$this->state = $this->getCurrentState($chatID);
		$this->chatID = $chatID;
	}

	public function get() : string
	{
		return $this->state;
	}

	public function set(string $state) : bool
	{
		if (!$this->stateExists($state))
		{
			return false;
		}

		$query = $this->db->prepare('
			INSERT INTO users_states
				(user, state)
			VALUES 
				(?, ?)
			ON DUPLICATE KEY UPDATE state = ?
		');
		$query->execute(array($this->chatID, $state, $state));

		return true;
	}

	public function clear() : bool 
	{
		$query = $this->db->prepare('
			DELETE FROM users_states
			WHERE 
				user = ?
		');
		return $query->execute(array($this->chatID));
	}

	private function getCurrentState(string $chat_id) : string
	{
		$query = $this->db->prepare('
			SELECT
				state
			FROM
				users_states
			WHERE
				user = ?
		');
		$query->execute(array($chat_id));
		$fetched = $query->fetch();

		return (!empty($fetched['state'])) ? $fetched['state'] : '';
	}

	private function stateExists(string $alias) : bool
	{
		$query = $this->db->prepare('
			SELECT
				count(alias)
			FROM
				states
			WHERE
				alias = ?
		');
		$query->execute(array($alias));

		return ($query->rowCount() > 0);
	}
}