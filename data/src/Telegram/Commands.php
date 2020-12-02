<?php
namespace Unclebot\Telegram;

use \Unclebot\Utils\Logger;
use \Unclebot\Telegram\Models\Text as TelegramText;
use \Unclebot\Telegram\Models\Image as TelegramImage;
use \Unclebot\Telegram\Models\ReplyMarkup\ReplyKeyboard;
use \Unclebot\Telegram\Models\ReplyMarkup\InlineKeyboard;

class Commands
{
	private $command;

	private $user;

	private $responseText;

	public function __construct(User $user, string $command, ResponseText $responseText)
	{
		$this->user = $user;
		$this->command = ltrim($command, '/');;
		$this->responseText = $responseText;
	}

	public function getResponseData()
	{
		$command = $this->command;

		switch ($command)
		{
			default:
				return array();
			case 'start':
				return $this->start();
		}
	}

	private function start()
	{
		$text = $this->responseText->get('start');

		$telegramTextModel = new TelegramText($text);
		$telegramTextModel->removeKeyboard();
		
		return $telegramTextModel->getData();
	}
}
