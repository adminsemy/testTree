<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/app.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="js/jquery-url.min.js"></script>
    <script src="js/app.js"></script>
    <title>Document</title>
</head>
<body>
    <!-- Вставляем текст поста -->
    <div id="0" class="card">
        <div class="card-body">
            <p class="card-text"><?= $post['text'] ?></p>
            <a href="#" class="card-link">Answer</a>
        </div>
    </div>
    <?php
        //Функция для вывода комментариев
        function viewCategory($array, $parent_id = 0)
        {
    
            //Условия выхода из рекурсии
            if (! isset($array[$parent_id])) {
                return;
            }
            //перебираем в цикле массив и выводим на экран
            foreach ($array[$parent_id] as $row) :
    ?>
            <div id="<?= $row['id'] ?>" class="card">
                <div class="card-body">
                    <p class="card-text"><?= $row['body'] ?></p>
                    <a href="#" class="card-link">Reply</a>
                    <?php viewCategory($array, $row['id']) ?>
                </div>
            </div>
    <?php
            endforeach;
        }
        //Вызываем функцию для вставки комментариев
        viewCategory($categories);
    ?>
    <!-- Форма для отправки комментариев -->
    <form class="form-answer" id="formAnswer">
        <input type="text" maxlength="255" required class="form-control" id="answer">
        <button type="submit" id="addComment" class="btn btn-primary">Submit</button>
    </form>
    <!-- Шаблон для комментария -->
    <div id="tempCard" class="card">
        <div class="card-body">
            <p class="card-text"></p>
            <a href="#" class="card-link">Reply</a>
        </div>
    </div>
</body>
</html>
