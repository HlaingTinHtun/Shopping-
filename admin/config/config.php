<?php

    try {
        $pdo = new PDO("mysql:dbname=blog_exe;host=localhost", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PODException $e) {
            die($e->getMessage());
        } catch(Excpetion $e) {
            die($e->getMessage());
        }
?>