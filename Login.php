<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php
if(isset($_POST["Submit"])){
$Username=$_POST["Username"];
$Password=$_POST["Password"];

if(empty($Username)||empty($Password)){
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("Login.php");
	
}
else{
	$Found_Account=Login_Attempt($Username,$Password);
	$_SESSION["User_Id"]=$Found_Account["id"];
	$_SESSION["Username"]=$Found_Account["username"];
	if($Found_Account){
	$_SESSION["SuccessMessage"]="Welcome  {$_SESSION["Username"]} ";
	Redirect_to("Dashboard.php");
		
	}else{
		$_SESSION["ErrorMessage"]="Invalid Username / Password";
	Redirect_to("Login.php");
	}
	
}	
}	


?>

<!DOCTYPE>

<html>
	<head>
		<title>Log-in</title>
                <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
                <script src="vendor/js/jquery-3.2.1.min.js"></script>
                <script src="vendor/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="vendor/css/adminstyles.css">
<style>
	.FieldInfo{
    color: rgb(251, 174, 44);
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-size: 1.2em;
}
body{
	background-color: #ffffff;
}

</style>
                
	</head>
	<body>
		<div style="height: 10px; background: #27aae1;"></div>

<div class="Line" style="height: 10px; background: #27aae1;"></div>
<div class="container-fluid">
<div class="row">
	
	<div class="col-sm-offset-4 col-sm-4">
		<br><br><br><br>
		<?php echo Message();
	      echo SuccessMessage();
	?>
	<h2>Welcome back !</h2>
	
<div>
<form action="Login.php" method="post">
	<fieldset>
	<div class="form-group">
	<label for="Username"><span class="FieldInfo">UserName:</span></label>
	<div class="input-group input-group-lg">
	<span class="input-group-addon">
	<span class="glyphicon glyphicon-envelope text-primary"></span>
	</span>
	<input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
	</div>	
	</div>
	
	<div class="form-group">
	<label for="Password"><span class="FieldInfo">Password:</span></label>
	<div class="input-group input-group-lg">
	<span class="input-group-addon">
	<span class="glyphicon glyphicon-lock text-primary"></span>
	</span>
	<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
	</div>
	</div>
	
	<br>
<input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">
	</fieldset>
	<br>
</form>

	</div> <!-- Ending of Main Area-->
	
</div> <!-- Ending of Row-->
	
</div> <!-- Ending of Container-->

	    
	</body>
</html>