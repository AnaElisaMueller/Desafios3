<?php

session_start();

require_once __DIR__.'/classes/Question.php';
require_once __DIR__.'/classes/Controller.php';
require_once __DIR__.'/classes/API.php';
require_once __DIR__.'/classes/Router.php';
require_once __DIR__.'/classes/RequestAPI.php';
require_once __DIR__.'/classes/Database.php';

$router = new Router();
$router->setMethod($_SERVER['REQUEST_METHOD']);
$router->setRoute($_SERVER['REQUEST_URI']); 

$router->verifyMethod();

$totalPaginas = count($_SESSION['questions']);

if(isset($_GET['page'])){
    $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT)-1;
    $_SESSION['page2'] = $page+1;
}

if(!$page||$page<0||$page>$totalPaginas-1){
    $page = 0;
    $_SESSION['page2'] = $page;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <META NAME="viewport" content="width=device-width, intial-scale=10">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <title>Trivia</title>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Trivia</h1>
    </div>
    <div class="form">
        
    </div>
    <div class="separator">
    </div>
    <div class="header">
        <h1>Options</h1>
    </div>
    <div class="list-options">
        <?php
        echo "<ul>";
        echo "<li>" . $_SESSION['questions'][$page]->getQuestion() . "</li>";
        $shuffle = shuffle($_SESSION['questions'][$page]->answers);
        foreach ($_SESSION['questions'][$page]->getAnswers() as $answer) {
            echo "<li>" . $answer . "</li>";
        }
        echo "<ul>";
        ?>
        
    </div>
    <div class="pagination_section">
        <?php
            if($page>0){
                echo "<nobr><a href='?page=" . $page . "'> << Anterior </a>";
            } else {
                echo "<nobr><a style='visibility: hidden'> << Anterior </a>";
            }
            foreach ($arrayPokemon as $key => $value) {
                if($key==$page){
                    $verifyActive= "active";
                } else{
                    $verifyActive= "noactive";
                }
                echo "<a href='?page=" . ($key+1) . "' class='$verifyActive'>" . ($key+1) . "</a>";
            }
            if($page<$totalPaginas-1){
                echo "<a href='?page=" . ($page+2) . "'>Próxima >></a></nobr>";
            }  else {
                echo "<a style='visibility: hidden';>Próxima >></a></nobr>";
            }   

        ?>
    </div>
    <div class="voltar">
        <input type="button" value="Voltar" onClick="history.go(-1)"> 
    </div>
    <div class="footer">
        <p>Desenvolvido por</p>
    </div>
</div>