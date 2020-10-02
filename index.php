<?php
//Основная страница с отображением поста и комментариев к нему
//работает только с допольнительным GET параметром id
//например index.php?id=1
use App\Helpers\GetPrepare;
use App\Helpers\View;
use App\Models\Comments;
use App\Models\Posts;
use Config\MySQLConnection;

require __DIR__.'/vendor/autoload.php';

//Созадем подключение к базе данных
$connect = new MySQLConnection();
//Создаем подключение к таблицам
$posts = new Posts($connect);
$comments = new Comments($connect);

//Проверяем и обрабатываем GET параметр
$post_id = (int)GetPrepare::get('id');

//Ищем нужный пост. Если нет - выводим сообщение об ошибке
try {
    $post = $posts->queryPostId($post_id);
} catch (Exception $e) {
    echo $e->getMessage(), "\n";
}
//Ищем нужные комментарии по id поста
$arr_cat = $comments->postComments((int)$post['id']);
$arr_cat = $arr_cat ?? [];

//Рендерим необходимый шаблон для ответа
echo View::render('index',['post' => $post, 'categories' => $arr_cat]);
