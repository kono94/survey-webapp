<?php
class Question{
    public $id;
    public $title;
    # 1 = Radio-singleselect, 2 = free text
    public $questionType;
    public $answers;

    public function __construct($id, $title, $questionType){
        $this->id = $id;
        $this->title = $title;
        $this->questionType = $questionType;
        $this->answers = array();
    }

    public function addAnswer($answer){
        $this->answers[] = $answer;
    }
}
?>