<?php
namespace Unclebot;

use Unclebot\Utils\Directory;
use Unclebot\Utils\Format;

final class Config
{
	private static $instance = null;

	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct()
	{
		$this->parseIniConfigurationFiles();
	}

	private function __clone(){}

	private function parseIniConfigurationFiles()
	{
		$config_dir = realpath(dirname(__FILE__) . '/../config/') . '/';

		$files = Directory::getFiles($config_dir);

		foreach ($files as $file)
		{
			$propertyName = Format::snakeCaseToCamelCase(basename($file, '.ini'));

			$this->$propertyName = parse_ini_file($config_dir . $file, true);
		}
	}
}
