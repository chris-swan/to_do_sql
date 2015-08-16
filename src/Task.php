<?php
    class Task
    {
        private $description;
        private $id;
//added $id
        function __construct($description, $id = null)
        {
            $this->description = $description;
            $this->id = $id;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }
        //after adding ID, and getId, modifying save function
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
//Replaced original stati function with this one below to deal with multiple tasks
        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            $tasks = array();
            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $new_task = new Task($description);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }
        //updated delete all function:

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks;");
        }
//added getId function
        function getId()
        {
            return $this->id;
        }
        //the add function find to search for the id:(I think this is where it goes...)
        static function find($search_id)
        {
            $found_task = null;
            $tasks = Task::getAll();
            foreach($tasks as $task) {
                $task_id = $task->getId();
                if ($task_id == $search_id) {
                    $found_task = $task;
                }
            }
            return $found_task;
        }
    
    }
?>