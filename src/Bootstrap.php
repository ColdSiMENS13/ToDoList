<?php

declare(strict_types=1);

namespace App;

use App\Controllers\TodoController;
use App\Database\DB;
use App\JsonResponse\JsonResponse;

class Bootstrap
{
    public function run(): void
    {
        $database = new DB('mysql', 'example', 'root', 'root');
        $controller = new TodoController($database);


        switch ($this->path()[1]){
            case '':
                $response = $controller->getTasks();
                $response->toResponse();
                break;
            case 'task':
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $response = $controller->getTaskById((int)$_GET['id']);
                    $response->toResponse();
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $taskContent = $_POST['task'];
                    $response = $controller->updateTaskById((int)$_GET['id'], $taskContent);
                    $response->toResponse();
                }

                if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    $response = $controller->deleteTaskById((int)$_GET['id']);
                    $response->toResponse();
                }
                break;
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $taskContent = $_POST['task'];
                    $response = $controller->createTask($taskContent);
                    $response->toResponse();
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
