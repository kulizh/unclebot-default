<?php
namespace Unclebot\Utils;

use \Unclebot\Exceptions\FileException;

/**
 * Класс работы с файлами
 *
 * Class File
 */
class File
{
	/** @var string Имя файла */
	private $filename;

	/**
	 * File constructor.
	 * @param string $filename Имя фала
	 * @param int $size Максимально допустимый размер файла в kbytes
	 */
	public function __construct($filename, $size = 0)
	{
		$this->filename = $filename;
		$this->check($size);
	}

	/**
	 * Существует ли файл?
	 *
	 * @return bool
	 */
	public function exists()
	{
		return is_readable($this->filename);
	}

	/**
	 * Читает данные из файла
	 *
	 * @return false|string
	 */
	public function read()
	{
		$filename = $this->filename;

		if (!$this->exists($filename))
		{
			throw new FileException('Не удалось найти файл ' . $filename);
		}

		$contents = file_get_contents($filename);

		if ((!$contents) || empty($contents))
		{
			throw new FileException('Не удалось получить содержимое файла ' . $filename);
		}

		return $contents;
	}

	/**
	 * Создает файл
	 *
	 * @param int $mod Права доступа
	 */
	public function create($mod = 0777)
	{
		$filename = $this->filename;

		fopen($filename, 'w+');
		chmod($filename, $mod);
	}

	/**
	 * Пишет данные в файл
	 *
	 * @param string $contents Данные для записи
	 * @param bool $append Продолжать (true) / перезаписывать (false)
	 * @return bool|int
	 */
	public function write($contents, $append = false)
	{
		$filename = $this->filename;

		if (!$this->exists())
		{
			$this->create();
		}

		if ($append)
		{
			$fpc = file_put_contents($filename, $contents, FILE_APPEND);
		}
		else
		{
			$fpc = file_put_contents($filename, $contents);
		}

		return $fpc;
	}

	/**
	 * Очищает файл
	 */
	public function clear()
	{
		$filename = $this->filename;

		file_put_contents($filename, '');
	}

	/**
	 * Проверяет необходимые параметры файла
	 *
	 * @param int $available_size Допустимый размер файла в kbytes
	 */
	public function check($available_size)
	{
		if (!$this->exists())
		{
			$this->create();
		}

		$size = $this->getSize();

		if ( (($size / 1024) > $available_size) && ($available_size !== 0) )
		{
			$this->clear();
		}
	}

	/**
	 * Возвращает размер файла в kbytes
	 *
	 * @return float|int
	 */
	private function getSize()
	{
		$filename = $this->filename;
		$file_size = filesize($filename);
		$file_size = round($file_size, 1);

		return $file_size;
	}
}
