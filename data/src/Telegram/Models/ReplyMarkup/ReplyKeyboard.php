<?php
namespace Unclebot\Telegram\Models\ReplyMarkup;

class ReplyKeyboard
{
	public $oneTime = true;

	public $resize = true;

	private $replyMarkup = '';

	public function __construct(array $buttons)
	{
		$keyboards = [];
		foreach ($buttons as $button) {
			if (!is_array($button))
			{
				$keyboards[] = array($button);
			}
			else
			{
				$keyboards[] = $button;
			}
		}

		$keyboard = array(
			'keyboard' => $keyboards,
			'one_time_keyboard' => $this->oneTime,
			'resize_keyboard' => $this->resize
		);

		$this->replyMarkup = json_encode($keyboard);
	}

	public function getReplyMarkup(): string
	{
		return $this->replyMarkup;
	}
}