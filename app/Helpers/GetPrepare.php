<?php
namespace App\Helpers;

/**
 * Класс для обработки GET запросов
 */
class GetPrepare
{    
    /**
     * Возвращает обработынный элемент GET запроса
     * 
     *
     * @param  string $name
     * @return string
     */
    public static function get(string $name): string
    {
        try {
            $idPost =  self::isGet($name);
            $idPost = self::prepare($idPost);
            return $idPost;
        } catch (\Exception $e) {
            echo $e->getMessage(), "\n";
        }
    }
    
    /**
     * Проверка на существование элемента GET запроса по имени
     * 
     *
     * @param  string $param
     * @return string|object
     */
    protected static function isGet(string $param)
    {
        if (isset($_GET[$param])) {
            return $_GET[$param];
        } else {
            throw new \Exception("GET parametr {$param} not found");
        }
    }
    
    /**
     * Обрабатывает нужный элемент GET запроса
     *
     * @param  string $prepare
     * @return string
     */
    protected static function prepare(string $prepare): string
    {
        $prepare = \trim($prepare);
        $prepare = \stripslashes($prepare);
        $prepare = \htmlspecialchars($prepare);
        return $prepare;
    }
}