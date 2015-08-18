<?php
    class Task
    {
        private $description;
        private $id;
//Added in private setting:
        private $due_date;
//Add due_date into the function construct
        function __construct($description, $due_date, $id = null)
        {
            $this->description = $description;
            $this->due_date = $due_date;
            $this->id = $id;
        }
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }
//Adding in function to get the due_date
        function setDue_date($due_date)
        {
            $this->due_date = (string) $due_date;
        }

        function getDescription()
        {
            return $this->description;
        }
//Adding in get due_date function
        function getDue_date($due_date)
        {
            return $this->due_date;
        }

        function getId()
        {
            return $this->id;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            //echo "var_dump in getAll";
            //var_dump($returned_tasks);
            $tasks = array();
            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
    //Adding in duedate in the for each....Could be wrong - double check
                $due_date = $task['due_date'];
    //Added in due date below to pull up with new task
                $new_task = new Task($description, $id, $due_date);
    //And agen down here in the array_push \/
                array_push($tasks, $new_task, $due_date);
            }
            return $tasks;
        }
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks;");
        }
        static function find($search_id)
        {
            $found_task = null;
            $tasks = Task::getAll();
            foreach ($tasks as $task)
            {
                $task_id = $task->getId();
                if ($task_id == $search_id)
                {
                    $found_task = $task;
                }
            }
            return $found_task;
        }
    }
?>