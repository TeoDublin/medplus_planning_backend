<?php

    function environment():string{
        return $_SERVER['HTTP_HOST']=='127.0.0.1:8080'?'dev':'prod';
    }