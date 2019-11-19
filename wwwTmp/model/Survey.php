<?php

class Survey{
    public $id;
    public $title;
    public $startTime;
    public $endTime;
    public $categoryID;
    public $categoryName;
    public $questions;
    public $description;

    public function __construct($id, $title, $description, $startTime, $endTime, $categoryID, $categoryName){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->categoryID = $categoryID;
        $this->categoryName = $categoryName;
        $this->questions = array();
    }

    public function addQuestion($question){
        $this->questions[$question->id] = $question;
    }
}
?>