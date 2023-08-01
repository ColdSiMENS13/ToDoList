<?php

class ToDoList
{
    private DataBase $dataBase;

    public function __construct(DataBase $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    public function path()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $result = explode("/", $path);

        return $result;

    }

    public function getTask()
    {
        $data = [];

        $query = "SELECT id, task ";
        $query .= "FROM todo ORDER BY id DESC";

        $result = $this->dataBase->exec($query);

        if (!$result || $result->rowCount() === 0) {

            return $data;

        }
        foreach ($result->fetchAll() as $r) {

            $data[] = new ToDo($r['id'], $r['task']);

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
        $path_url = $this->path();

        if ($path_url[1] === "edit-task") {

            $id = $path_url[2];

            $query = "SELECT task ";
            $query .= "FROM todo ";
            $query .= "WHERE id=$id";

            $result = $this->dataBase->exec($query);
            $data = $result->fetch();

        }
        return $data;
    }

    public function updateTaskById()
    {
        $path_url = $this->path();

        if (isset($_POST['update']) && $path_url[1] === "edit-task") {

            $id = $path_url[2];
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

                    echo "<script>window.location='/'</script>";

                }

            }
            return $data;
        }

    }

    public function deleteTaskById()
    {
        $path_url = $this->path();

        if ($path_url[1] === "delete-task") {

            $id = $path_url[2];
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

                    echo "<script>window.location='/'</script>";

                }
            }
            return $data;
        }
    }
}

?>
