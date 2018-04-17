<?php
    require_once '../class/user.php';
    require_once 'config.php';

    
    $hname = filter_input(INPUT_POST, 'hname', FILTER_SANITIZE_STRING);
    $hdesc = filter_input(INPUT_POST, 'hdesc', FILTER_SANITIZE_STRING);
    $adminid = filter_input(INPUT_POST, 'adminid', FILTER_SANITIZE_STRING);
    //echo $user_role;
    if($user->hRegistration($hname, $hdesc, $adminid)) {
        print 'Hotel Registration Successful.';
        
        die;
    } else {
        $user->printMsg();
        die;
    }
