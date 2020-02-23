<?php

namespace App\Helpers;

/**
 * Class DatabaseUrlParser
 * @package TomFerry\Config
 */
class DatabaseUrlParser extends AbstractUrlParser
{
    /**
     * @return array|mixed
     */
    public function parse()
    {
        $payload = $this->defaults;

        if (!empty($this->url)) {
            $parsedUrl = parse_url($this->url);
            $scheme = array_key_exists('scheme', $parsedUrl) ? $parsedUrl['scheme'] : null;
            $host = array_key_exists('host', $parsedUrl) ? $parsedUrl['host'] : null;
            $port = array_key_exists('port', $parsedUrl) ? $parsedUrl['port'] : null;
            $username = array_key_exists('user', $parsedUrl) ? $parsedUrl['user'] : null;
            $password = array_key_exists('pass', $parsedUrl) ? $parsedUrl['pass'] : null;
            $database = array_key_exists('path', $parsedUrl) ? ltrim($parsedUrl['path'], '/') : null;

            if (!empty($scheme)) {
                $payload['driver'] = $scheme == 'postgres' ? 'pgsql' : $scheme;
            }

            if (!empty($host)) {
                $payload['host'] = $host;
            }

            if (!empty($port)) {
                $payload['port'] = $port;
            }

            if (!empty($database)) {
                $payload['database'] = $database;
            }

            if (!empty($username)) {
                $payload['username'] = $username;
            }

            if (!empty($password)) {
                $payload['password'] = $password;
            }
        }

        return $payload;
    }
}
