<?php
    require_once '../class/user.php';
    require_once 'config.php';

    $email = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    if( $user->login( $email, $password) ) {
        die;
    } else {
        $user->printMsg();
        die;
    }
