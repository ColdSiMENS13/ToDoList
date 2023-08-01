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
                var_dump($controller->getTasks());
                break;
            case 'task':
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    var_dump($controller->getTaskById((int)$_GET['id']));
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $taskContent = $_POST['task'];
                    var_dump($controller->updateTaskById((int)$_GET['id'], $taskContent));
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
