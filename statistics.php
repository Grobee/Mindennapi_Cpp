<?php

class Statistics {
    private $sql;
    private $data;
    private $correct_count;
    private $incorrect_count;
    private $total_count;

    public function __construct(mysqli $sqlcon){
        $this->sql = $sqlcon;
        $this->data = new ArrayObject();

        $this->generateFullList();
        $this->countCorrect();
    }

    public function getCorrectPercentage() { return $this->total_count == 0 ? 0 : number_format(($this->correct_count / $this->total_count) * 100, 2); }
    public function getIncorrectPrecentage() { return $this->total_count == 0 ? 0 : number_format(($this->incorrect_count / $this->total_count) * 100, 2); }
    public function getFullList() { return $this->data; }

    private function countCorrect(){
        foreach($this->data as $answer){
            $answer['correct'] == 1 ? $this->correct_count++ : $this->incorrect_count++;
            $this->total_count++;
        }
    }

    private function generateFullList(){
        $this->sql->query('SET NAMES utf8');
        $query = "SELECT a.correct AS 'correct', a.date AS 'date', CONCAT(m.forename, ' ', m.surname) AS 'name',
            q.question AS 'question', q.difficulty AS 'difficulty' FROM answers a INNER JOIN members m ON a.id_member = m.id_member
            INNER JOIN questions q ON a.id_question = q.id_question";

        $result = $this->sql->query($query);

        if($result->num_rows) while($value = $result->fetch_assoc()) $this->data->append($value);
    }
}