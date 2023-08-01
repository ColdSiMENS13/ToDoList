<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DB;
use App\Entities\Todo;

class TodoController
{
    private DB $dataBase;

    public function __construct(DB $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    public function getTasks()
    {
        $data = [];

        $query = "SELECT id, task ";
        $query .= "FROM todo ORDER BY id DESC";

        $result = $this->dataBase->exec($query);

        if (!$result || $result->rowCount() === 0) {

            return $data;

        }
        foreach ($result->fetchAll() as $r) {

            $data[] = new Todo($r['id'], $r['task']);

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

    public function getTaskById(int $id): ?Todo
    {
        $query = "SELECT id, task ";
        $query .= "FROM todo ";
        $query .= "WHERE id=$id";

        $result = $this->dataBase->exec($query)->fetch();
        return count($result) ? new Todo($result['id'], $result['task']) : null;
    }

    public function updateTaskById(int $id, string $taskContent): array
    {
        $data['taskMsg'] = '';
        $validation = false;

        if (empty($taskContent)) {
            $data['taskMsg'] = "Task field is required";
        }

        if (empty($data['taskMsg'])) {

            $validation = true;

        }

        if ($validation) {

            $query = "UPDATE todo SET ";
            $query .= "task ='$taskContent' ";
            $query .= "WHERE id=$id";

            $result = $this->dataBase->exec($query);

            if ($result) {
                echo "<script>window.location='index.php'</script>";
            }

        }
        return $data;
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
