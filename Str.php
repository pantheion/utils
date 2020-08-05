<?php

namespace Pantheion\Utils;

use Ramsey\Uuid\Uuid;

class Str
{
    public function after(string $string, string $after)
    {
        return substr($string, strpos($string, $after) + strlen($after));
    }

    public function afterLast(string $string, string $after)
    {
        return substr($string, strrpos($string, $after) + strlen($after));
    }

    public function append(string $string, string $append)
    {
        return $string . $append;
    }

    public function before(string $string, string $before)
    {
        return substr($string, 0, strpos($string, $before));
    }

    public function beforeLast(string $string, string $before)
    {
        return substr($string, 0, strrpos($string, $before));
    }

    public function between(string $string, string $after, string $before)
    {
        return substr(
            $string, 
            strpos($string, $after) + strlen($after), 
            strpos($string, $before) - strlen($after)
        );
    }

    public function contains(string $string, string $contains)
    {
        return strpos($string, $contains) === false ? false : true;
    }

    public function containsAll(string $string, array $all)
    {
        foreach($all as $substring) {
            if(strpos($string, $substring) === false) {
                return false;
            }
        }

        return true;
    }

    public function containsAny(string $string, array $any)
    {
        foreach ($any as $substring) {
            if (strpos($string, $substring) !== false) {
                return true;
            }
        }

        return false;
    }

    public function endsWith(string $string, string $end)
    {
        return substr($string, -strlen($end)) === $end;
    }

    public function isEmpty(string $string)
    {
        return $string === '';
    }

    public function isNotEmpty(string $string)
    {
        return $string !== '';
    }

    public function isUuid(string $string)
    {
        return Uuid::isValid($string);
    }

    public function length(string $string)
    {
        return strlen($string);
    }

    public function limit(string $string, int $limit, string $append = "...")
    {
        return substr($string, 0, $limit) . $append;
    }

    public function prepend(string $string, string $prepend)
    {
        return $prepend . $string;
    }

    public function random(int $length)
    {
        $length = ($length < 4) ? 4 : $length;
        return bin2hex(random_bytes(($length - ($length % 2)) / 2));
    }

    public function replaceArray(string $find, array $replace, string $string, int $count = null)
    {
        $result = $string;
        foreach($replace as $replaceItem)
        {
            $result = $this->replaceFirst($find, $replaceItem, $result);
        }

        return $result;
    }

    public function replaceFirst(string $find, string $replace, string $string)
    {
        $pos = strpos($string, $find);
        if ($pos === false) {
            return $string;
        }

        return substr_replace($string, $replace, $pos, strlen($find));
    }

    public function replaceLast(string $find, string $replace, string $string)
    {
        $pos = strrpos($string, $find);
        if ($pos === false) {
            return $string;
        }

        return substr_replace($string, $replace, $pos, strlen($find));
    }

    public function slug(string $string, string $replace = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $replace, $string);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $replace);
        $text = preg_replace('~-+~', $replace, $text);

        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function startsWith(string $string, string $start)
    {
        return substr($string, 0, strlen($start)) === $start;
    }

    public function substr(string $string, int $start, int $length)
    {
        return substr($string, $start, $length);
    }

    public function ucfirst(string $string)
    {
        return ucfirst($string);
    }

    public function uuid()
    {
        return Uuid::uuid4()->toString();
    }

    public function words(string $string, int $count, string $append)
    {
        $wordArray = explode(" ", $string);

        if(count($wordArray) <= $count) {
            return $string;
        }

        return join(" ", array_slice($wordArray, 0, $count)) . $append;
    }
}