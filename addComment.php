<?php
/* Сервис для вставки комментариев в базу данных */

use App\Helpers\PostPrepare;
use App\Models\Comments;
use App\Models\Posts;
use Config\MySQLConnection;

require __DIR__.'/vendor/autoload.php';

//Создаем подключение к базе данных
$connect = new MySQLConnection();
//Создаем подключение к нужным таблицам
$comment = new Comments($connect);
$posts = new Posts($connect);

//Проверяем и обрабатываем нужные POST данные
$postId = (int)PostPrepare::get('postId');
$commentId = (int)PostPrepare::get('commentId');
$message = PostPrepare::get('message');

//Проверяем существование нужного поста и родительского комментария
$isPost = $posts->isPost($postId);
$isComment = $comment->isComment($commentId);

/* 
*   Сохраняем новый комментарий 
*   По умолчанию ставим '0', так как может вернутся значение '0'
*   Это может означать, что вставка не произошла, так как
*   нарушена целостность связи таблиц
*/
$currentComment = '0';
if ($isPost && $isComment && $message !== '') {
    $currentComment = $comment->save($postId, $commentId, $message);
}

//Если id вставленного комментария '0' то возвращаем сообщение
//с ошибкой
$currentComment = $currentComment !== '0' ? $currentComment : 'Insert error' ;

//Возвращаем JSON ответ
echo json_encode($currentComment);