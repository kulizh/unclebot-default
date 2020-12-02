<?php
namespace Unclebot\Telegram;

use \Unclebot\Chooser\Helpers\Ajax;
use \Unclebot\Telegram\Models\Text as TelegramText;
use \Unclebot\Telegram\Models\ReplyMarkup\ReplyKeyboard;

class StateMachine
{
	private $user;

	private $message;

	private $responseText;

	public function __construct(User $user, string $message, ResponseText $responseText)
	{
		$this->user = $user;
		$this->message = $message;
		$this->responseText = $responseText;
	}

	public function handle() : array
	{
		$state = $this->user->state->get();

		switch ($state)
		{
			default:
				return array();
		}
	}
}