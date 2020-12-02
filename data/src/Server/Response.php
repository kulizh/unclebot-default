<?php
namespace Unclebot\Server;

/**
 * Ответ сервера
 *
 * Class Response
 */
class Response
{
	/**
	 * Генерирует ответ в случае ошибки с кодом этой ошибки
	 *
	 * @param int $code Код ошибки
	 * @param string $message Пояснительное сообщение
	 */
	public static function error($code, $message = '')
	{
		$code_message = 'Undefined error';

		if (!empty(Response\Error::$codes[$code]))
		{
			$code_message = Response\Error::$codes[$code];
		}

		if (!empty($message))
		{
			$code_message = $message;
		}

		$response = array(
			'error' => $code . ' ' . $code_message
		);

		self::output($response);
	}

	/**
	 * Генерирует ответ в случае успешной обработки запроса
	 *
	 * @param array $data
	 */
	public static function success($data = array())
	{
		$response = array(
			'error' => '',
		);

		if (!empty($data))
		{
			$response['result'] = $data;
  		}

		self::output($response);
	}

	/**
	 * Кодирует ответ в JSON
	 *
	 * @param array $response Ответ сервера
	 * @param int $exit_code Код ответа
	 */
	private static function output(array $response, $exit_code = 200)
	{
		$message = json_encode($response);

		echo $message;

		exit($exit_code);
	}
}
