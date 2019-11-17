<?php
class SurveyData {
    protected $connection;

    public function connect()
    {
        $this->connection = new PDO("mysql:host=mysql;dbname=test", "root", "root");
    }

    public function getAllSurveys()
    {
        $query = $this->connection->prepare("SELECT * FROM survey");
        $query->execute();

        return $query;
    }
}
?>