<?php
namespace Unclebot\Telegram\Models\ReplyMarkup;

class InlineKeyboard
{
	private $replyMarkup = '';

	public function __construct(array $buttons)
	{
		$keyboards = [];

		foreach ($buttons as $button)
		{
			$keyboards[] = array(
				$button
			);
		}


		$keyboard = array(
			"inline_keyboard" => array($buttons)
		);

		$this->replyMarkup = json_encode($keyboard);
	}

	public function getReplyMarkup(): string
	{
		return $this->replyMarkup;
	}
}