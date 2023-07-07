<?php

class ToDoList
{

  public function getTask()
  {

    global $conn;
    $data['data'] = [];

    $query = "SELECT id, task ";
    $query .= "FROM todo ORDER BY id DESC";

    $result = $conn->query($query);

    if ($result) {

      if ($result->num_rows > 0) {

        $data['data'] = $result->fetch_all(MYSQLI_ASSOC);

      }

    }

    return $data;

  }

  public function createTask()
  {

    global $conn;

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

        $result = $conn->query($query);

        if ($result) {

          $data['success'] = "Task is added successfuly";

        }

      }
      return $data;
    }

  }

  public function editTaskById()
  {

    global $conn;

    $data = [];

    if (isset($_GET['edit-task']) && !empty($_GET['edit-task'])) {

      $id = $_GET['edit-task'];

      $query = "SELECT task ";
      $query .= "FROM todo ";
      $query .= "WHERE id=$id";

      $result = $conn->query($query);
      $data = $result->fetch_assoc();

    }
    return $data;
  }

  public function updateTaskById()
  {

    global $conn;

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

        $result = $conn->query($query);

        if ($result) {

          echo "<script>window.location='index.php'</script>";

        }

      }
      return $data;
    }

  }

  public function deleteTaskById()
  {

    global $conn;

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

        $result = $conn->query($query);

        if ($result) {

          echo "<script>window.location='index.php'</script>";

        }
      }
      return $data;
    }
  }

  public function getDate(){

    
  }

}

?>