<?php
namespace Unclebot\Telegram\Models;

use Unclebot\Telegram\Response;

class Text extends Model
{
	public function __construct(string $text, string $reply_markup = '', $disable_preview = true)
	{
		Response::setMethod('/sendMessage');

		$this->data = array(
			'text' => $text,
			'parse_mode' => $this->parseMode,
			'reply_markup' => $reply_markup,
			'disable_web_page_preview' => $disable_preview
		);
	}
}