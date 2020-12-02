<?php
namespace Unclebot\Utils;

class Logger
{
	public $rotate = true;

	private $file;

	public function __construct(string $type)
	{
		$filename = FILES_DIR . 'log/' . $type;

		if ($this->rotate)
		{
			$filename .= '_' . date('d.m.Y');
		}

		$filename .= '.log';

		$this->file = new File($filename);
	}

	/**
	 * Добавляет дату и время к логгируемому сообщению
	 *
	 * @param string  &$message Текст сообщения
	 */
	protected function addTime(&$message)
	{
		$message = "=============== " . date('H:i:s') . " ===============\n" . $message . "\n\n";
	}

	/**
	 * Пишет сообщение лога в файл
	 *
	 * @param string $message Сообщение лога
	 */
	public function write($message)
	{
		$this->addTime($message);

		$this->file->write($message, true);
	}
}
