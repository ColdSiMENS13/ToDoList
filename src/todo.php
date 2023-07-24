<?php

class ToDo {

    private $id;
    private $task;
    public function __construct($id, $task){
        $this->id = $id;
        $this->task = $task;
    }

    public function getId(){
        return $this->id;
    }

    public function getTask(){
        return $this->task;
    }

}
?>
