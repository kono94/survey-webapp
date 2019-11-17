<?php

class Answer{
    public $id;
    public $title;

    public function __construct($id, $title){
        $this->id = $id;
        $this->title = $title;
    }
}
?>