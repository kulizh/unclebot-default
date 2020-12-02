<?php
namespace Unclebot\Server;

final class Request
{
    /** @var Request $_instance Экзмепляр self */
    private static $_instance;

    /** @var array $headers Заголовки запроса */
    private $headers = array();

    /** @var array $queryExploded Маршрут запроса в виде массива */
    private $queryExploded = array();

    /** @var array $data Тело запроса ($_REQUEST) */
    private $data = array();

    /** @var string $query Маршрут запроса в виде строки */
    private $query = '';

    /** @var string $method Метод запроса */
    private $method = '';

    /**
     * Возвращает экземпляр класса (реализует Синглтон)
     *
     * @return Request
     */
    public static function getInstance()
    {
        if ( !self::$_instance )
        {
            new self();
        }

        return self::$_instance;
    }

    /**
     * Private due to singleton implementation.
     * Request constructor.
     */
    private function __construct()
    {
        $this->setHeaders()->setQuery();
        $this->setQueryExploded()->setMethod();
        $this->setData();

        self::$_instance = $this;
    }

    /**
     * Возвращает значение поля headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Возвращает значение поля query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Возвращает значение поля queryExploded
     *
     * @return array
     */
    public function getQueryExploded()
    {
        return $this->queryExploded;
    }

    /**
     * Возвращает значение поля method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Возвращает значение поля data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function getRequestMethod()
	{
		if (!empty($this->queryExploded[0]))
		{
			return $this->queryExploded[0];
		}

		return '';
	}

	public function getRequestParams()
	{
		$query = $this->queryExploded;

		unset($query[0]);

		return array_values($query);
	}

    /**
     * Устанавливает значение поля headers
     *
     * @return $this
     */
    private function setHeaders()
    {
        $this->headers = getallheaders();

        return $this;
    }

    /**
     * Устанавливет значение поля query
     *
     * @return $this
     */
    private function setQuery()
    {
        $this->query = (!empty($_REQUEST['url'])) ? $_REQUEST['url'] : '';
        $this->query = rtrim($this->query, '/');

        return $this;
    }

    /**
     * Устанавливает значение поля queryExploded
     *
     * @return $this
     */
    private function setQueryExploded()
    {
        $this->queryExploded = array($this->query);

        if (stripos($this->query, '/') !== false)
        {
            $this->queryExploded = explode('/', $this->query);
        }


        return $this;
    }

    /**
     * Устанавливает значение поля method
     *
     * @return $this
     */
    private function setMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        return $this;
    }

    /**
     * Устанавливает значение поля data
     *
     * @return $this
     */
    private function setData()
    {
        $this->data = $_REQUEST;

        return $this;
    }

    /**
     * Устанавливает значение поля method (произвольное значение)
     *
     * @param $method
     */
    public function setCustomMethod($method)
    {
        $this->method = $method;
    }
}
