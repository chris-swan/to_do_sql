<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:3306;dbname=to_do';
    $user = 'root';
    $password = 'root';
    // $db = 'to_do';
    // $host = '127.0.0.1';
    $port = 3306;
    $DB = new PDO($server, $user, $password);

    // $link = mysql_connect(
    //     "$host:$port", 
    //     $user, 
    //     $password
    // );

    // $db_selected = mysql_select_db(
    //     $db, 
    //     $link
    // );

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/tasks", function() use ($app) {
        return $app ['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

    $app->get("/categories", function() use ($app) {
        return $app ['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/tasks", function() use ($app) {
        $task = new Task($_POST['description']);
        $task->save();
        return $app ['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>