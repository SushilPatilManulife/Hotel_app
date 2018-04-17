<?php
class User{
    
    private $pdo;
    private $user;
    private $msg;
    
    public function dbConnect($conString, $user, $pass){
        if(session_status() === PHP_SESSION_ACTIVE){
            try {
                $pdo = new PDO($conString, $user, $pass);
                $this->pdo = $pdo;
                return true;
            }catch(PDOException $e) { 
                $this->msg = 'Connection did not work out!';
                return false;
            }
        }else{
            $this->msg = 'Session did not start.';
            return false;
        }
    }

    public function getUser(){
        return $this->user;
    }

    public function login($email,$password){
        if(is_null($this->pdo)){
            $this->msg = 'Connection did not work out!';
            return false;
        }else{
            $pdo = $this->pdo;
            
            $stmt = $pdo->prepare('SELECT id, fname, lname, email, password, user_role FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            //echo $user['user_role'];
            if(password_verify($password, $user['password'])){
                    $this->user = $user;
                    session_regenerate_id();
                    $_SESSION['user']['id'] = $user['id'];
                    $_SESSION['user']['fname'] = $user['fname'];
                    $_SESSION['user']['lname'] = $user['lname'];
                    $_SESSION['user']['email'] = $user['email'];
                    $_SESSION['user']['user_role'] = $user['user_role'];
                    return true;
            }else{
                $this->msg = 'Invalid login information.';
                return false;
            } 
        }
    }
    
     public function getHotels(){
       
        if(is_null($this->pdo)){
            $this->msg = 'Connection did not work out!';
            return [];
        }else{
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT hotel_id, hotel_name, hotel_desc FROM hotel');
            $stmt->execute();
            $result = $stmt->fetchAll(); 
            return $result; 
        }
    }
    
     public function getUsers(){
       
        if(is_null($this->pdo)){
            $this->msg = 'Connection did not work out!';
            return [];
        }else{
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT hotel_bookId,  user_id FROM hotel_booking');
            $stmt->execute();
            $result1 = $stmt->fetchAll(); 
            return $result1; 
        }
    }
    
    public function registration($email,$fname,$lname,$pass, $userRole){
        //echo $user_role;
        $pdo = $this->pdo;
        $pass = $this->hashPass($pass);
        $stmt = $pdo->prepare('INSERT INTO users (fname, lname, email, password, user_role) VALUES (?, ?, ?, ?, ?)');
        if($stmt->execute([$fname,$lname,$email,$pass, $userRole])){
                return true;
        }else{
            $this->msg = 'Registration failed.';
            return false;
        }
    }
     public function hRegistration($hname,$hdesc, $adminid){
        //echo $user_role;
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('INSERT INTO hotel (hotel_name, hotel_desc, admin_id) VALUES (?, ?, ?)');
        if($stmt->execute([$hname,$hdesc, $adminid])){
                return true;
        }else{
            $this->msg = 'Hotel Registration failed.';
            return false;
        }
    }
    
    public function bookHotel($hotelid, $userid){
        //echo $hotelid;
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('INSERT INTO hotel_booking (hotel_id, user_id) VALUES (?, ?)');
        if($stmt->execute([$hotelid, $userid])){
                return true;
        }else{
            $this->msg = 'Hotel Booking Failed.';
            return false;
        }
    }

    private function checkEmail($email){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? limit 1');
        $stmt->execute([$email]);
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    private function hashPass($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public function printMsg(){
        print $this->msg;
    }

    public function logout() {
        $_SESSION['user'] = null;
        session_regenerate_id();
        return true;
    }

    public function listUsers(){
        if(is_null($this->pdo)){
            $this->msg = 'Connection did not work out!';
            return [];
        }else{
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT id, fname, lname, email FROM users');
            $stmt->execute();
            $result = $stmt->fetchAll(); 
            return $result; 
        }
    }

    public function render($path,$vars = '') {
        ob_start();
        include($path);
        return ob_get_clean();
    }

    public function indexHead() {
        print $this->render(indexHead);
    }

    public function indexTop() {
        print $this->render(indexTop);
    }

    public function loginForm() {
        print $this->render(loginForm);
    }

    public function activationForm() {
        print $this->render(activationForm);
    }

    public function indexMiddle() {
        print $this->render(indexMiddle);
    }

    public function registerForm() {
        print $this->render(registerForm);
    }

    public function indexFooter() {
        print $this->render(indexFooter);
    }

    public function userPageHead() {
        print $this->render(userPageHead);
    }
    
    public function userPageTop() {
        print $this->render(userPageTop);
    }
    
    public function userPageUser() {
        print $this->render(userPageUser);
    }
    
    public function userPageMiddle() {
        print $this->render(userPageMiddle);
    }
    
    public function userPageAdmin() {
        print $this->render(userPageAdmin);
    }
    
    public function userPageFooter() {
        print $this->render(userPageFooter);
    }
    
    
    public function userPage() {
	$users = [];
	if($_SESSION['user']['user_role'] == 2){
		$users = $this->listUsers();
        $users = $this->getHotels();
        
	}
        //$users = $this->getUsers();
    print $this->render(userPage,$users);
    }
}