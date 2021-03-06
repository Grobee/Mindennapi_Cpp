<?php

namespace Robert;
use mysqli;
use Question;

require_once("Question.php");
class QuestionList {
    /** Question array */
    private $questions;
    private $sql;

    /* constructor, initialize variables */
    public function __construct(mysqli $sql){
        $this->questions = new \ArrayObject();
        $this->sql = $sql;
    }

    /* Populate the list of questions */
    public function populate($bottom = null, $number = null){
        /* query the db */
        $this->sql->query("SET NAMES utf8;");

        if($bottom != null && $number != null) $result = $this->sql->query("SELECT * FROM questions ORDER BY number ASC LIMIT $bottom, $number");
        else $result = $this->sql->query("SELECT * FROM questions ORDER BY number ASC");

        /* array of question attributes from the database */
        /* iterator */
        $i = 0;

        while($row = $result->fetch_assoc()){
            $this->questions->append(new Question($row['id_question'], $row['question'], $row['answer_1'], $row['answer_2'], $row['answer_3'], $row['answer_4'], $row['correct_answer'], $row['difficulty'], $row['number']));
            $i++;
        }
    }

    /* get the questions */
    public function getQuestions(){
        return $this->questions;
    }

    public function getQuestion($id){
        foreach($this->questions as $question){
            if($question->id == $id) return $question;
        }

        return false;
    }
}
