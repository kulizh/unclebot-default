<?php
namespace Unclebot\Exceptions;

use Throwable;
use \Unclebot\Utils\Logger;

/**
 * Абстрактный класс логгируемых исключений
 *
 * Class LoggedExceptionAbstract
 */
abstract class ExceptionAbstract extends \Exception
{
	/** @var string $message  */
	protected $message = 'New exception thrown';

	/** @var string $type Тип исключения */
	protected $type = 'common';

	/**
	 * LoggedExceptionAbstract constructor.
	 * @param string $message Текст сообщения
	 * @param int $code Код ошибки
	 * @param Throwable|null $previous
	 */
	public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	/**
	 * Преобразовывает объект в строку
	 *
	 * @return string
	 */
	public function __toString()
	{
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	protected function writeToLog()
	{
		$type = $this->type;
		$logger = new Logger($type);

		$text = $this->message . "\n" . 'thrown in ' . $this->file . '(' . $this->line . ')';
		$text .= "\nTrace:\n" . $this->getTraceAsString();

		$logger->write($text);
	}

}
