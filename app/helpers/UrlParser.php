<?php

namespace App\Helpers;

/**
 * Interface UrlParser
 * @package TomFerry\Config
 */
interface UrlParser
{
    /**
     * @param $key
     * @return mixed
     */
    public function setKey($key);

    /**
     * @param $url
     * @return mixed
     */
    public function setUrl($url);

    /**
     * @param array $defaults
     * @return mixed
     */
    public function setDefaults($defaults = []);

    /**
     * @return mixed
     */
    public function parse();
}
