<?php
namespace Unclebot\Telegram\Models;

use Unclebot\Telegram\Response;

class Image extends Model
{
	public function __construct(string $photo, string $caption, string $reply_markup = '', $set_response = true)
	{
		if ($set_response)
		{
			Response::setMethod('/sendPhoto');
		}

		$this->data = array(
			'photo' => $photo,
			'caption' => $caption,
			'parse_mode' => $this->parseMode,
			'reply_markup' => $reply_markup
		);
	}
}