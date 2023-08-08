<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DB;
use App\Entities\Todo;
use App\Interfaces\Response;
use App\JsonResponse\JsonResponse;

class TodoController
{
    private DB $dataBase;

    public function __construct(DB $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    public function getTasks(): Response
    {
        $data = [];

        $query = "SELECT id, task ";
        $query .= "FROM todo ORDER BY id DESC";

        $result = $this->dataBase->exec($query);

        if (!$result || $result->rowCount() === 0) {

            return new JsonResponse($data);

        }
        foreach ($result->fetchAll() as $r) {

            $data[] = new Todo($r['id'], $r['task']);

        }

        return new JsonResponse($data);

    }

    public function createTask(string $taskContent): Response
    {
        $data['taskMsg'] = '';
        $validation = false;

        if (empty($taskContent)) {
            $data['taskMsg'] = "Task field is required";
        }

            if (!empty($taskContent) && empty($data['taskMsg'])) {

                $validation = true;

            }

            if ($validation) {

                $query = "INSERT INTO todo";
                $query .= "(task) ";
                $query .= "VALUES ('$taskContent')";

                $result = $this->dataBase->exec($query);

                if ($result) {

                    $data['success'] = "Task is added successfully";

                }

            }
            return new JsonResponse($data);
        }

    public function getTaskById(int $id): Response
    {
        $data = null;
        $query = "SELECT id, task ";
        $query .= "FROM todo ";
        $query .= "WHERE id=$id";

        $result = $this->dataBase->exec($query)->fetch();
        if ($result){
            $result = new Todo($result['id'], $result['task']);
            return new JsonResponse($result);
        } else {
            return new JsonResponse($data);
        }
    }

    public function updateTaskById(int $id, string $taskContent): Response
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
                $data['taskMsg'] = "Task successfully updated";
            }

        }
        return new JsonResponse($data);
    }

    public function deleteTaskById(int $id): Response
    {

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

                    $data['taskMsg'] = "Task successfully deleted";

                }
            }
            return new JsonResponse($data);
    }
}

?>
