<?php
namespace Unclebot\Utils;

final class Format
{
	/**
	 * Конвертирует строку из snake_case в CamelCase
	 *
	 * @param string $subject Строка для конвертации
	 * @return string
	 */
	public static function snakeCaseToCamelCase(string $subject) : string
	{
		$result = str_replace('_', '', ucwords($subject, '_'));

		return lcfirst($result);
	}
}