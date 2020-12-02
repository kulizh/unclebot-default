<?php
namespace Unclebot\Utils\Cli;

final class Response
{
	private static $errorLabel = "\033[0;31mError!\033[0m ";

	private static $successLabel = "\033[0;32mOK!\033[0m ";

	public static function write(string $message)
	{
		echo $message . PHP_EOL;
	}

	public static function error(string $message)
	{
		$message = self::$errorLabel . $message;

		self::write($message);
	}

	public static function success(string $message = '')
	{
		$message = self::$successLabel . $message;

		self::write($message);
	}
}