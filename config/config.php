<?php
    // $options = array(
    //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    // );

    // $pdo = new PDO("mysql:dbname=blogapp;host=localhost",'root','');

    try {
            $pdo = new PDO("mysql:dbname=shopping;host=localhost", 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PODException $e) {
            die($e->getMessage());
        } catch(Excpetion $e) {
            die($e->getMessage());
        }  
?>