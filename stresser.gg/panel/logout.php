<?php



session_start();



ob_start();



session_destroy();





@header("Location: login");



ob_end_flush();











?>