<?php
namespace Unclebot\Utils;

class Cli
{
	public static function verifySAPI(): bool
	{
		return php_sapi_name() === 'cli';
	}

	public static function getParams(array $argv, array $keys): array
	{
		unset($argv[0]);

		if (count($argv) !== count($keys))
		{
			Response::error('Arguments fetch error');
			die();
		}

		return array_combine($keys, $argv);
	}
}