<?php
namespace Unclebot\Exceptions;

use \Throwable;
use \Unclebot\Server\Response;
use \Unclebot\Utils\Cli;

class FileException extends ExceptionAbstract
{
	protected $message = 'Ошибка обработки файла';

	protected $type = 'critical';

	protected $isCli = false;

	public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->isCli = Cli::verifySAPI();

		if (!$this->isCli)
		{
			Response::error(500);
		}

		die($message . "\n");
	}
}
