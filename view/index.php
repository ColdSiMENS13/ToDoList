<!DOCTYPE html>
<html lang="en">

<head>
    <title>Task MANAGER</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body>

<div class="container my-5">

    <h2>To Do List</h2>

    <div class="row">
        <div class="col-sm-6">
            <form method="post">
                <p class="text-danger">
                    <?php
                    echo $createTask['success'] ?? '';
                    echo $createTask['taskMsg'] ?? '';
                    ?>
                </p>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter Something..." name="task"
                           value="<?php echo $editTask['task'] ?? ''; ?>">
                    <button type="submit" class="btn btn-primary"
                            name="<?php echo count($editTask) ? 'update' : 'add'; ?>"><?php echo count($editTask) ? 'update' : 'add'; ?></button>
                </div>

            </form>

            <?php

            $getList = $list->getTask();

            if (count($getList)) {
                foreach ($getList as $task) {
                    ?>

                    <div class="row my-3">
                        <div class="col-sm-10">
                            <?php
                            echo '(' .$task->getId(). ') ' . $task->getTask();
                            ?>
                        </div>
                        <div class="col-sm-1">
                            <a href="index.php?edit-task=<?php echo $task->getId(); ?>"
                               class="text-success text-decoration-none">
                                edit
                            </a>
                        </div>
                        <div class="col-sm-1">
                            <a href="index.php?delete-task=<?php echo $task->getId(); ?>"
                               class="text-danger text-decoration-none">
                                delete
                            </a>
                        </div>
                    </div>
                    <hr>
                    <?php
                }
            }
            ?>

        </div>
        <div class="col-sm-6">
        </div>
    </div>

</div>

</body>

</html>
