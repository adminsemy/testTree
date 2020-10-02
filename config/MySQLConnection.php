<?php

namespace Config;
use PDO;

/**
 * Наследуемся от PDO PHP для загрузки своих настроек для подключения
 * к базе данных
 */
class MySQLConnection extends PDO
{    
    /**
     * Принимаем имя файла настроек (по умолчанию setting.ini)
     * и настраиваем подключение к нужной базе данных
     *
     * @param  string $file
     * @return void
     */
    public function __construct(string $file = 'setting.ini')
    {
        $settings = parse_ini_file($file, true);
        if (!$settings) {
            throw new \Exception('Unable to open ' . $file . '.');
        }       
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['dbname'];
       
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}
