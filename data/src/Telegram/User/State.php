<?php
namespace Unclebot\Telegram\User;

use PDO;
use Unclebot\Utils\Database;

class State
{
    private PDO $db;
    private string $state;
    private string $chatID;

    public function __construct(string $chat_id)
    {
        $this->db = Database::connect();
        $this->chatID = $chat_id;

        $this->state = $this->getCurrentState();
    }

    public function get(): string
    {
        return $this->state;
    }

    public function set(string $state): bool
    {
        if (!$this->stateExists($state)) {
            return false;
        }

        $query = $this->db->prepare('
			INSERT INTO users_states
				(user, state)
			VALUES
				(?, ?)
			ON DUPLICATE KEY UPDATE state = ?
		');
        $query->execute([$this->chatID, $state, $state]);

        return true;
    }

    public function clear(): bool
    {
        $query = $this->db->prepare('
			DELETE FROM users_states
			WHERE
				user = ?
		');
        return $query->execute([$this->chatID]);
    }

    private function getCurrentState(): string
    {
        $query = $this->db->prepare('
			SELECT
				state
			FROM
				users_states
			WHERE
				user = ?
		');
        $query->execute([$this->chatID]);
        $fetched = $query->fetch();

        return $fetched['state'] ?? '';
    }

    private function stateExists(string $alias): bool
    {
        $query = $this->db->prepare('
			SELECT
				count(alias)
			FROM
				states
			WHERE
				alias = ?
		');
        $query->execute([$alias]);

        return ($query->rowCount() > 0);
    }
}
