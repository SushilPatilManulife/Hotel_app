<?php
    require_once '../class/user.php';
    require_once 'config.php';

    
    $hotelid = $_POST['hotelid'];
    $userid = $_POST['userid'];
    
    if($user->bookHotel($hotelid,$userid)) {
        print 'Hotel Booking Request Send.';
        
        die;
    } else {
        $user->printMsg();
        die;
    }