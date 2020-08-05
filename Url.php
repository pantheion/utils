<?php

namespace Pantheion\Utils;

class Url
{
    protected $format = "%s://%s%s";

    public function action(string $controller, string $action, array $param = null)
    {
        return $this->url("...");
    }

    public function asset(string $asset)
    {
        return $this->url("...");
    }

    public function route(string $route, array $params = null, $relative = false)
    {
        return $this->url("...");
    }

    public function secureAction(string $controller, string $action, array $param = null)
    {

    }

    public function secureAsset(string $asset)
    {

    }

    public function secureRoute(string $route, array $params = null)
    {

    }

    public function secure(string $url)
    {
        return sprintf(
            $this->format,
            "https",
            $_SERVER['HTTP_HOST'],
            $url
        );
    }

    public function url(string $url)
    {
        return sprintf(
            $this->format,
            "http",
            $_SERVER['HTTP_HOST'],
            $url
        );
    }
}
