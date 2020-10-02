<?php

namespace App\Models;

use Exception;
use PDO;

/**
 * Модель для работы с таблицей 'comments'
 */
class Comments
{
        
    /**
     * Содержит подключение к нужной базе данных
     *
     * @var mixed
     */
    protected $dbc;
    
        
    /**
     * Содержит имя таблицы. По умолчанию 'comments'
     *
     * @var string
     */
    protected $table = 'comments';
    
    /**
     * Принимает PDO подключение и сохраняет в защищенное свойство
     *
     * @param  PDO $dbc
     * @return void
     */
    public function __construct(PDO $dbc)
    {
        $this->dbc = $dbc;
    }
        
    /**
     * Запрашивает все комментарии по id поста и формирует
     * древовидный многомерный массив, в котором ключ = id 
     * категории у которой есть дочерние категории. По этому
     * массиву формируется древо бесконечной вложенности в
     * браузере
     *
     * @param  int $post_id
     * @return array
     */
    public function postComments(int $post_id): array
    {
        $comments = [];

        $selectPostComments = $this->queryPostComments($post_id);

        if ([] === $selectPostComments) {
            return $selectPostComments;
        }

        foreach ($selectPostComments as $row) {
            if (! isset($comments[$row['parent_id']])) {
                $comments[$row['parent_id']] = [];
            }
            $comments[$row['parent_id']][] = $row;
        }
        
        return $comments;
    }
    
    /**
     * Осуществляет поиск всех комментариев по id поста
     *
     * @param  int $post_id
     * @return array
     */
    public function queryPostComments(int $post_id): array
    {
        $query = $this->dbc->prepare("SELECT id, parent_id, topic_id, body
                                        FROM $this->table
                                        WHERE topic_id = :post_id
                                        ORDER BY id");
        $query->bindParam(':post_id', $post_id);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    /**
     * Проверяет наличие комментария по id
     * Если передается '0', то возвращается true
     * '0' - родительский комментарий у поста
     *
     * @param  int $id
     * @return bool
     */
    public function isComment(int $id): bool
    {
        if (0 === $id) {
            return true;
        }
        $query = $this->dbc->prepare("SELECT EXISTS (SELECT id FROM $this->table WHERE id = :id LIMIT 1)");
        $query->bindParam(':id', $id);
        $query->execute();
        //Проверяем количество вернувшихся строк. Ожидаем '1' (значит, комментарий с таким id есть)
        $isComment = '1'; 
        if ($isComment === $query->fetch(PDO::FETCH_NUM)[0]) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Принимает данные для сохраниения нового комментария
     * Возвращает id сохраненного комментария или '0' при
     * ошибки вставки данных (например, когда поста с 
     * передаммым id)
     *
     * @param  int $postId
     * @param  int $parentId
     * @param  string $message
     * @return string
     */
    public function save($postId, $parentId, $message): string
    {
        $query = $this->dbc->prepare("INSERT INTO $this->table (parent_id, topic_id, body) VALUES (:parent_id, :topic_id, :body)");
        $query->bindParam(':parent_id', $parentId);
        $query->bindParam(':topic_id', $postId);
        $query->bindParam(':body', $message);
        $query->execute();
        $result = $this->dbc->lastInsertId();
        return $result;
    }
}
