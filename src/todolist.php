<?php

class ToDoList
{
    private DataBase $dataBase;
    public function __construct(DataBase $dataBase){
        $this->dataBase = $dataBase; 
    }
    public function getTask()
    {
        $data = [];

        $query = "SELECT id, task ";
        $query .= "FROM todo ORDER BY id DESC";

        $result = $this->dataBase->exec($query);

        if (!$result || $result->num_rows === 0) {
            
            return $data = [];

        }else {

            foreach($result->fetch_all(MYSQLI_ASSOC) as $r){

                $data[] = new ToDo($r['id'], $r['task']);

            }

        }
        
        return $data;

    }

    public function createTask()
    {
        if (isset($_POST['add'])) {

            $task = $_POST['task'];
            $data['taskMsg'] = '';
            $validation = false;

            if (empty($task)) {

                $data['taskMsg'] = "Empty task field!";

            }

            if (!empty($task) && empty($data['taskMsg'])) {

                $validation = true;

            }

            if ($validation) {

                $query = "INSERT INTO todo";
                $query .= "(task) ";
                $query .= "VALUES ('$task')";

                $result = $this->dataBase->exec($query);

                if ($result) {

                    $data['success'] = "Task is added successfuly";

                }

            }
            return $data;
        }

    }

    public function editTaskById()
    {
        $data = [];

        if (isset($_GET['edit-task']) && !empty($_GET['edit-task'])) {

            $id = $_GET['edit-task'];

            $query = "SELECT task ";
            $query .= "FROM todo ";
            $query .= "WHERE id=$id";

            $result = $this->dataBase->exec($query);
            $data = $result->fetch_assoc();

        }
        return $data;
    }

    public function updateTaskById()
    {
        if (isset($_POST['update']) && isset($_GET['edit-task']) && !empty($_GET['edit-task'])) {

            $id = $_GET['edit-task'];
            $task = $_POST['task'];

            $data['taskMsg'] = '';
            $validation = false;

            if (empty($task)) {

                $data['taskMsg'] = "Task field is required";

            }

            if (empty($data['taskMsg'])) {

                $validation = true;

            }

            if ($validation) {

                $query = "UPDATE todo SET ";
                $query .= "task ='$task' ";
                $query .= "WHERE id=$id";

                $result = $this->dataBase->exec($query);

                if ($result) {

                    echo "<script>window.location='index.php'</script>";

                }

            }
            return $data;
        }

    }

    public function deleteTaskById()
    {
        if (isset($_GET['delete-task']) && !empty($_GET['delete-task'])) {

            $id = $_GET['delete-task'];
            $data['taskMsg'] = '';
            $validation = false;

            if (empty($data['taskMsg'])) {

                $validation = true;

            }

            if ($validation) {

                $query = "DELETE FROM todo ";
                $query .= "WHERE id =$id";

                $result = $this->dataBase->exec($query);

                if ($result) {

                    echo "<script>window.location='index.php'</script>";

                }
            }
            return $data;
        }
    }
}

?>
