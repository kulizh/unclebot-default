<?php
namespace Unclebot\Utils;

/**
 * Класс подключения к БД
 *
 * Singleton class Database
 * @uses PDO PHP Data Objects
 */
class Database
{
	/** @var self $_instance Instance */
	private static $_instance;

	/** @var null|\PDO Экземпляр класса */
	private static $_db;

	/** @var array Данные для подключения к БД */
	private static $dbCredentials;

	/**
	 * Database constructor.
	 * Инициализирует подключение
	 *
	 * Ограничивает реализацию __construct()
	 */
	private function __construct()
	{
		$this->initialize();
	}

	// Ограничиает клонирование обекта
	protected function __clone(){}

	// Ограничивает восстановлеение ресурса
	protected function __wakeup(){}

	/**
	 * Инициализирует подключение к БД
	 *
	 * @return void
	 */
	private function initialize()
	{
		$options = array(
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
		);

		try
		{
			$db = new \PDO("mysql:host=" . self::$dbCredentials['host'] . ";dbname=" . self::$dbCredentials['name'],
				self::$dbCredentials['user'], self::$dbCredentials['password'], $options);
		}
		catch (\Exception $exception)
		{
			die('Не удалось создать экземпляр класса PDO' . $exception->getMessage() );
		}

		self::$_instance = $db;
	}

	/**
	 * Возвращает экземпляр класса
	 *
	 * @param array $credentials Данные для подключения
	 * @throws \Exception
	 * @return Database|PDO|null
	 */
	public static function connect(array $credentials = array())
	{
		self::$dbCredentials = $credentials;

		if(self::$_instance instanceof \PDO)
		{
			return self::$_instance;
		}
		else
		{
			if(self::$_db instanceof self)
			{
				throw new \Exception('Ошибка работы с БД');
			}
			else
			{
				self::$_db = new self();
				return self::$_instance;
			}
		}
	}
}
