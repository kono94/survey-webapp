<?php
require 'model/Question.php';
require 'model/Answer.php';
require 'model/Survey.php';
class SurveyData
{
    protected $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $this->connection = new PDO("mysql:host=mysql;dbname=test", "root", "root");
    }

    public function getAllSurveys()
    {
        $surveys = array();
        $query = $this->connection->prepare("SELECT survey.*, category.name AS category_name FROM survey INNER JOIN category ON survey.category_id = category.id");
        $query->execute();

        foreach($query->fetchAll() as $row){
            $surveys[] = new Survey($row['id'], $row['title'], $row['description_text'], $row['start_date'], $row['end_date'], $row['category_id'], $row['category_name']);
        }
        return $surveys;
    }

    public function getSingleSurvey($id)
    {
        $query = $this->connection->prepare(" 
        SELECT a.title AS answer_title, a.id AS answer_id, 
              q.id AS question_id, q.title AS question_title, q.question_type_id AS question_type,
              s.id AS survey_id, s.title AS survey_title, s.start_date, s.end_date, s.category_id,
              s.description_text, c.name AS category_name
        FROM answer AS a
        LEFT JOIN question_answer_option AS qao
        ON a.id =  qao.answer_id
        LEFT JOIN question AS q
        ON qao.question_id = q.id
        LEFT JOIN survey_question AS sq        
        ON sq.question_id = q.id
        LEFT JOIN survey AS s
        ON sq.survey_id = s.id
        LEFT JOIN category AS c
        ON s.category_id = c.id
        WHERE s.id = :id");

        $params = [':id' => $id];
        $query->execute($params);

        if(!$query){
            return false;
        }
        $rows = $query->fetchAll();

        # no survey found
        if(sizeof($rows) == 0){
            return false;
        }

        $survey = new Survey($rows[0]['survey_id'], $rows[0]['survey_title'], $rows[0]['description_text'],$rows[0]['start_date'],$rows[0]['end_date'], $rows[0]['category_id'], $rows[0]['category_name']);
        foreach ($rows as $row) {
            $questionID = $row['question_id'];
            if (!$survey->questions[$questionID]) {
                $survey->addQuestion(new Question($questionID, $row['question_title'], $row['question_type']));
            }
            $survey->questions[$questionID]->addAnswer(new Answer($row['answer_id'], $row['answer_title']));
        }
        return $survey;
    }
}
