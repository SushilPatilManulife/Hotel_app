<?php
session_start();
define('conString', 'mysql:host=localhost;dbname=login');
define('dbUser', 'root');
define('dbPass', 'root');


define('userfile', 'user.php');
define('loginfile', 'login.php');
define('registerfile', 'register.php');
define('registerHotel', 'registerHotel.php');
define('bookHotel', 'bookHotel.php');

define('indexHead', 'inc/indexhead.htm');
define('indexTop', 'inc/indextop.htm');
define('loginForm', 'inc/loginform.php');
define('indexMiddle', 'inc/indexmiddle.htm');
define('registerForm', 'inc/registerform.php');
define('indexFooter', 'inc/indexfooter.htm');

define('userPageHead', 'inc/userpage_head.php');
define('userPageTop', 'inc/userpage_top.htm');
define('userPageUser', 'inc/userpage_user.htm');
define('userPageMiddle', 'inc/userpage_middle.php');
define('userPageAdmin', 'inc/userpage_admin.php');
define('userPageFooter', 'inc/userpage_footer.php');

define('userPage', 'inc/userpage.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

$user = new User();
$user->dbConnect(conString, dbUser, dbPass);
