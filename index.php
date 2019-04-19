<?php 
if(isset($_POST["Submit"])){
Redirect_to("dashboard.php");}
	
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
<form action="index.php" method="post">

<input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">

</form>
	    
	</body>
</html>