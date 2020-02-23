<?php

namespace App\Helpers;


/**
 * Class AbstractUrlParser
 * @package TomFerry\Config
 */
abstract class AbstractUrlParser implements UrlParser
{
    /**
     * @var
     */
    protected $key = null;

    /**
     * @var
     */
    protected $url = null;

    /**
     * @var array
     */
    protected $defaults = [];

    /**
     * AbstractUrlParser constructor.
     * @param null $key
     */
    public function __construct($key = null)
    {
        $this->setKey($key);
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        if (!empty($this->key)) {
            $this->url = getenv($this->key);
        }
        return $this;
    }

    public function setEnvReference($reference)
    {
        if ($key = getenv($reference)) {
            $this->setKey($key);
            return $this;
        }
        throw new \Exception("Database environment variable ${reference} is not set.");
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param array $defaults
     * @return $this|mixed
     */
    public function setDefaults($defaults = [])
    {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * @return mixed
     */
    public abstract function parse();
}
