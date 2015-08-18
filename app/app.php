<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost8000;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $link = mysql_connect(
        "$host:$port", 
        $user, 
        $password
    );

    $db_selected = mysql_select_db(
        $db, 
        $link
    );



    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('categories' => Category::getAll()));
    });

    $app->get("/tasks", function() use ($app) {
        return $app ['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

    $app->get("/categories{id}", function($id) use ($app) {
        $category = Category::find($id);
        return $app ['twig']->render('categories.html.twig', array('categories' => Category, 'tasks'=> $category->getTasks_>getAll()));
    });
//Adding in a due date function double check this!
 //   $app->get('/tasks' function() use ($app){
   //     return $app ['twig']->render('tasks.html.twig'), array ('due_date' => Task::getAll());
   // });

    $app->post("/tasks", function() use ($app) {
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $task = new Task($description, $id = null, $category_id);
        $task->save();
        $category = Category::find($category_id);
        return $app['twig']->render('category.html.twig', array('category' => $category, 'tasks' => $category->getTasks()));
        });

//Adding in a post for the due date
    $app->post("/due_date", function() use ($app) {
        $due_date = new Task($_POST['due_date']);
        $due_date->save();
        return $app ['twig']->render('tasks.html.twig', array('due_date' => Task::getall()));
    });

    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('index.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>