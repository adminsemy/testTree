<?php

namespace App\Helpers;

/**
 * Класс для обработки POST сообщений+
 */
class PostPrepare
{    
    /**
     * Возвращает обработанный элемент POST запроса
     *
     * @param  string $name
     * @return string
     */
    public static function get(string $name): string
    {
        try {
            $post = self::isPost($name);
            $post = self::prepare($post);
            return $post;
        } catch (\Exception $e) {
            echo $e->getMessage(), "\n";
        }
    }
    
    /**
     * Возвращает запрощенный элемент POST запроса
     * или выбрасывает исключение в случае ошибки
     *
     * @param  string $param
     * @return string|object
     */
    protected static function isPost(string $param)
    {
        if (isset($_POST[$param])) {
            return $_POST[$param];
        } else {
            throw new \Exception("POST parametr {$param} not found");
        }
    }
    
    /**
     * брабатывает переданный элемент POST запроса
     *
     * @param  string $prepare
     * @return string
     */
    protected static function prepare(string $prepare): string
    {
        $prepare = \trim($prepare);
        $prepare = \stripslashes($prepare);
        $prepare = \htmlspecialchars($prepare);
        $prepare = \mb_strimwidth($prepare,0,255);
        return $prepare;
    }
}