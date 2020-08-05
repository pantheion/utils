<?php

namespace Pantheion\Utils;

use ICanBoogie\Inflector;

class Inflection
{
    protected $inflector;

    public function __construct()
    {
        $this->inflector = Inflector::get('en');    
    }

    public function camelize(string $string)
    {
        return $this->inflector->camelize($string);
    }

    public function classerize(string $string)
    {
        return $this->inflector->camelize($this->inflector->singularize($string));
    }

    public function functionize(string $string)
    {
        return $this->inflector->camelize($string, Inflector::DOWNCASE_FIRST_LETTER);
    }

    public function humanize(string $string)
    {
        return $this->inflector->humanize($string);
    }

    public function hyphenize(string $string)
    {
        return $this->inflector->hyphenate($string);
    }

    public function lowercase(string $string)
    {
        return strtolower($string);
    }

    public function pluralize(string $string)
    {
        return $this->inflector->pluralize($string);
    }

    public function singularize(string $string)
    {
        return $this->inflector->singularize($string);
    }

    public function tablerize(string $string)
    {
        return $this->inflector->underscore($this->inflector->pluralize($string));
    }

    public function titleize(string $string)
    {
        return $this->inflector->titleize($string);   
    }

    public function underscorize(string $string)
    {
        return $this->inflector->underscore($string);
    }

    public function uppercase(string $string)
    {
        return strtoupper($string);
    }
}
