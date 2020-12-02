<?php
namespace Unclebot\Telegram\Models;

abstract class Model
{
	protected $parseMode = 'HTML';

	protected $data = array();

	public function setParseMode(string $mode)
	{
		$this->parseMode = $mode;
	}

	public function getData() : array
	{
		return $this->data;
	}

	public function removeKeyboard()
	{
		$this->data['reply_markup'] = json_encode(array('remove_keyboard' => true));
	}

}