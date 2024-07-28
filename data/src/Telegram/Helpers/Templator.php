<?php
namespace Unclebot\Telegram\Helpers;

class Templator
{
    public static function r(string $key, string $value, string $text): string {
        return str_replace('{{' . $key . '}}', $value, $text);
    }

    public static function ar(array $keys, array $values, string $text): string {
        if (count($keys) !== count($values)) {
            throw new \Exception('Templator: keys and values count doesnt match in ' . $text);
        }

        foreach($keys as &$key) {
            $key = "{{{$key}}}";
        }

        return str_replace($keys, $values, $text);
    }

    public static function formatDatetime(string $datetime): string {
        return date('d.m.Y H:i', strtotime($datetime));
    }
}