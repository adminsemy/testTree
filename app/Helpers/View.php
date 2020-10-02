<?php
namespace App\Helpers;

/**
 * Вспомогательный класс для подключения шаблонов html
 */
class View
{    
    /**
     * Подключаем нужный шаблон и рендерим его
     *
     * @param  string $tmp
     * @param  array $vars
     * @return string
     */
    public static function render(string $tmp, array $vars = array()): string
    {
        if (self::isFile($tmp)) {
            \ob_start();
            \extract($vars);
            require 'templates/'.$tmp.'.tpl.php';
            return \ob_get_clean();
        } else {
            throw new \Exception("File not found");
        }
    }
    
    /**
     * Проверяем, есть ли файл шаблона
     *
     * @param  string $name
     * @return bool
     */
    protected static function isFile(string $name): bool
    {
        return \file_exists('templates/'.$name.'.tpl.php');
    }
}