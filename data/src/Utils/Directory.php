<?php
namespace Unclebot\Utils;

use Unclebot\Exceptions\DirectoryException;

class Directory
{
	public static function getFiles(string $directory): array
	{
		$files = scandir($directory);

		if (!$files || empty($files))
		{
			throw new DirectoryException('Empty or unscannable directory');
		}

		foreach ($files as $k => &$file)
		{
			if ($file[0] === '.')
			{
				unset($files[$k]);
			}
		}

		return array_values($files);
	}
}