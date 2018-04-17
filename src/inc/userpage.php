<?php require_once '../class/user.php';
if((isset($_SESSION['user']['id']) && isset($_SESSION['user']['user_role'])))
{

require_once 'config.php';
	
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">
    <title>Login and Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/style.css" rel="stylesheet" />
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">
    	<div class="row">
            <h2>Welcome <?php print $_SESSION['user']['fname'].' '.$_SESSION['user']['lname']; ?></h2>      
			
					  <?php 
      if($_SESSION['user']['user_role'] == 2){
    	
      ?>
            
    		<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">List of Hotels</a>
							</div>
							
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
    <form id="register-form" method="post" role="form" style="display: block;">
     <span id="msg" style="color:red"></span>
      
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Hotel</th>
      <th scope="col">Description</th>
      <th scope="col">Picture</th>
      <th scope="col">Booking</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
      <?php 
          $count=1;
         
    	foreach ($vars as $user) {
    	?>
    
       <tr>
      <th scope="row"><?=$count?></th>
      <td><?=$user['hotel_name']?></td>
      <td><?=$user['hotel_desc']?></td>
       <td><img src="../img/photo3.jpg" ></td>
     <td> 
        <!--<a href="" name="register-submit" id="register-submit"  value="2">Sign</a>-->
         <button type="button" name="register-submit" id="register-submit" onclick="subm(this)"  value="2">Request</button>
         </td>
          <input type="hidden" name="hotelid" id="hotelid" value="<?=$user['hotel_id']?>">
         <input type="hidden" name="userid" id="userid" value="<?= $_SESSION['user']['id']?>">
    </tr>
    <?php
            $count++;
    	}
      ?>
  </tbody>
</table>
        
<script type="text/javascript">
	
    function subm(bookHotel)
    {   var userid=document.getElementById('userid').value;
        var hotelid=document.getElementById('hotelid').value;
        //console.log(hotelid);
        var http = new XMLHttpRequest();
        var url = "bookHotel.php";
        var params = "hotelid="+bookHotel.value+"&userid="+userid+"&hotelid="+hotelid;
        http.open("POST", url, true);

        
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState == 4 && http.status == 200) {
                alert(http.responseText);
                if(http.responseText)
                {
                    document.getElementById("msg").innerHTML="*Note: Booking need owner approval!";
                }
                else{
                    document.getElementById("msg").innerHTML="*Note: Booking requested Failed!";
                }
            }
        }
        http.send(params);
    }
</script>
</form>

    	<?php
    	//}
    }else{ ?>
                 <div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Add New Hotel</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Approve Booking</a>
							</div>
						</div>
						<hr>
					</div>               
                                
       <div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" method="post" role="form" style="display: block;">
                                    <div class="form-group">
	<input type="text" name="hname" id="hname" tabindex="1" class="form-control" placeholder="Hotel Name" value="">
</div>
<div class="form-group">
	<input type="text" name="hdesc" id="hdesc" tabindex="2" class="form-control" placeholder="Hotel Description">
</div>
<div class="form-group">
	<input type="file" name="hpic" id="hpic" tabindex="3" class="form-control" placeholder="Hotel Picture">
</div>
        <input type="hidden" name="adminid" id="adminid" value="<?= $_SESSION['user']['id']?>">                             
<div class="form-group">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<input type="button" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$("#login-submit").click(function(){
			if($("#hname").val() != "" && $("#hdesc").val() != "" ){
				$.ajax({
				  method: "POST",
				  url: "<?=registerHotel?>",
				  data: { hname: $("#hname").val(), hdesc: $("#hdesc").val(), adminid: $("#adminid").val() }
				}).done(function( msg ) {
				    
				    	alert(msg);
				});
			}else{
				alert("New hotel registered successfully!");
			}
		});
	});
</script>
</form>
<form id="register-form" method="post" role="form" style="display: none;">
    <span id="msg" style="color:red"></span>
      
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Hotel</th>
      <th scope="col">User</th>
      <th scope="col">Approve</th>
      
    </tr>
  </thead>
  <tbody>
      <?php 
          $count=1;
         
    	foreach ($vars as $user) {
    	?>
    
       <tr>
      <th scope="row"><?=$count?></th>
      
      <td><?=$user['hotel_name']?></td>
      <td><?=$user['hotel_desc']?></td>
     <td><img src="../img/photo3.jpg" width="20%" height="20%"></td>
           <td> 
        <!--<a href="" name="register-submit" id="register-submit"  value="2">Sign</a>-->
         <button type="button" name="register-submit" id="register-submit" onclick="subm(this)"  value="2">Sign </button>
         </td>
          <input type="hidden" name="hotelid" id="hotelid" value="<?=$user['hotel_id']?>">
         <input type="hidden" name="userid" id="userid" value="<?= $_SESSION['user']['id']?>">
    </tr>
    <?php
            $count++;
    	}
      ?>
  </tbody>
</table>
        
<script type="text/javascript">
	
    function subm(bookHotel)
    {   var userid=document.getElementById('userid').value;
        var hotelid=document.getElementById('hotelid').value;
        //console.log(hotelid);
        var http = new XMLHttpRequest();
        var url = "bookHotel.php";
        var params = "hotelid="+bookHotel.value+"&userid="+userid+"&hotelid="+hotelid;
        http.open("POST", url, true);

        
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState == 4 && http.status == 200) {
                alert(http.responseText);
                if(http.responseText)
                {
                    document.getElementById("msg").innerHTML="*Note: Booking need owner approval!";
                }
                else{
                    document.getElementById("msg").innerHTML="*Note: Booking requested Failed!";
                }
            }
        }
        http.send(params);
    }
</script>

       
    
    <?php } ?>
  <p><a href='logout.php'>Logout</a></p>

                                    
                                    
                                </form></div></div></div>
                                    
                                    
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
}
else{
    $_SESSION["MSG"]="Invalid Access";
    header("Location:index.php");
}
     ?>