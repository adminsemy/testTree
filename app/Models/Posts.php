<?php

namespace App\Models;

use PDO;

/**
 * Класс для работы с таблицей постов
 */
class Posts
{    
    /**
     * Сохраняем подключение к базе данных
     *
     * @var PDO
     */
    protected $dbc;    
    /**
     * Имя таблицы. По умолчанию 'posts'
     *
     * @var string
     */
    protected $table = 'posts';
    
    /**
     * Принимаем нужное подключение к базе данных 
     * и сохраняем его в свойство текущего объекта
     *
     * @param  PDO $dbc
     * @return void
     */
    public function __construct(PDO $dbc)
    {
        $this->dbc = $dbc;
    }
    
    /**
     * Ищем нужный пост по его id. Если не ничего не найдено
     * то бросам исключение
     *
     * @param  int $id
     * @return void
     */
    public function queryPostId(int $id)
    {
        $query = $this->dbc->prepare("SELECT id, text FROM $this->table WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new \Exception("Post id = ${id} not found");
        }
        return $result;
    }
    
    /**
     * Проверяем существование поста по его id.
     *
     * @param  int $id
     * @return bool
     */
    public function isPost(int $id): bool
    {
        $query = $this->dbc->prepare("SELECT EXISTS (SELECT id FROM $this->table WHERE id = :id LIMIT 1)");
        $query->bindParam(':id', $id);
        $query->execute();
        //Проверяем количество вернувшихся строк. Ожидаем '1' (значит, пост с таким id есть)
        $isPost = '1';
        if ($isPost === $query->fetch(PDO::FETCH_NUM)[0]) {
            return true;
        } else {
            return false;
        }
    }
}
