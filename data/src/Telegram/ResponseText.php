<?php
namespace Unclebot\Telegram;

use PDO;
use Unclebot\Utils\Database;

class ResponseText
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function get(string $alias): string
    {
        $query = $this->db->prepare('
			SELECT
				`text`
			FROM
				`response_text`
			WHERE
				`alias` = ?
		');
        $query->execute([$alias]);

        return $query->fetch()['text'] ?? '';
    }
}
