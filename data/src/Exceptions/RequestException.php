<?php
namespace Unclebot\Exceptions;

use \Throwable;
use \Unclebot\Server\Response;

class RequestException extends ExceptionAbstract
{
	protected $message = 'Ошибка запроса';

	protected $type = 'request';

	public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->writeToLog();

		if (!empty($code))
		{
			Response::error($code);
		}
		else
		{
			Response::error(500);
		}
	}
}
