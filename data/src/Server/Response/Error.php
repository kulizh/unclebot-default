<?php
namespace Unclebot\Server\Response;

/**
 * Class Error
 */
class Error
{
	/**
	 * @var array $codes HTTP response status codes
	 */
	public static $codes = array(
		204 => 'Empty Body',

		400 => 'Bad Request',
		401 => 'Unauthorized',
		403 => 'Forbidden',
		404 => 'Not found',
		405 => 'Method not allowed',
		410 => 'Gone',
		429 => 'Too Many Requests',

		500 => 'Internal Server Error'
	);
}
