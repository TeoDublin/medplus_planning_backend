<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    function environment():string{
        return $_SERVER['HTTP_HOST']=='127.0.0.1:8080'?'dev':'prod';
    }