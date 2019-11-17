<?php

class Answer{
    public $id;
    public $title;
    public $questionAnswerOptionID;

    public function __construct($id, $title, $questionAnswerOptionID){
        $this->id = $id;
        $this->title = $title;
        $this->questionAnswerOptionID = $questionAnswerOptionID;
    }
}
?>