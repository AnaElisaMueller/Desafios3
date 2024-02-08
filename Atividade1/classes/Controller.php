<?php

class Controller
{
    static function getQuestions(Database $database)
    {

        $api = new API();
        $api->setAmount('1'); 
        $api->setUrl("https://opentdb.com/api.php?amount=".$api->getAmount()."");

        $url = $api->url;
        $response = RequestAPI::request($url);

        foreach ($response['results'] as $result) {
            $question = new Question();
            $question->setCategory($result['category']);
            $question->setType($result['type']);
            $question->setDifficulty($result['difficulty']);
            $question->setQuestion($result['question']);
            $question->setCorrectAnswer($result['correct_answer']);
            $question->setIncorrectAnswers($result['incorrect_answers']);
            $question->setAnswers($result['incorrect_answers'], $result['correct_answer']);
            shuffle($question->answers);
        }
        
        $_SESSION['question'] = get_object_vars($question);
        $question->incorrect_answers=json_encode($question->incorrect_answers);
        $question->answers=json_encode($question->answers);
        $database->insert($question);
    }
}

