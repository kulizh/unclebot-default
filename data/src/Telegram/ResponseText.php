<?php
namespace Unclebot\Telegram;

use PDO;

class ResponseText
{
	private $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
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
		$query->execute(array($alias));

		return $query->fetch()['text'];
	}
}