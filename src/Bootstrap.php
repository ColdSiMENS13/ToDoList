<?php

declare(strict_types=1);

namespace App;

use App\Controllers\TodoController;
use App\Database\DB;

class Bootstrap
{
    public function run(): void
    {
        $database = new DB('mysql', 'example', 'root', 'root');
        $controller = new TodoController($database);


        switch ($this->path()[1]){
            case '':
                header("Content-Type: application/json");
                echo json_encode($controller->getTasks(), JSON_PRETTY_PRINT);
                break;
            case 'task':
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    header("Content-Type: application/json");
                    echo json_encode($controller->getTaskById((int)$_GET['id']));
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $taskContent = $_POST['task'];
                    header("Content-Type: application/json");
                    echo json_encode($controller->updateTaskById((int)$_GET['id'], $taskContent));
                }

                if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    header("Content-Type: application/json");
                    echo json_encode($controller->deleteTaskById((int)$_GET['id']));
                }
                break;
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $taskContent = $_POST['task'];
                    header("Content-Type: application/json");
                    echo json_encode($controller->createTask($taskContent));
                }
                break;
            default:
                var_dump('The end');
        }
    }

    public function path(): array
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        return explode("/", $path);
    }
}
