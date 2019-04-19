<?php require_once("include/db.php")?>
<?php require_once("include/sessions.php")?> 
<?php require_once("include/functions.php")?> 
<?php require_once("include/captcha.php"); ?>
<?php confirm_login(); ?>
<?php 
if(isset($_POST["Submit"])){
	
	$Title=$_POST["Title"];
	$Category=$_POST["Category"];
	$Post=$_POST["Post"];
	date_default_timezone_set("Asia/Dhaka");
	$CurrentTime=time();
/*

*/
	$DateTime=strftime("%d-%B-%Y %H:%M:%S",$CurrentTime);
	echo $DateTime;
	$Admin =$_SESSION["Username"];
	$Image=$_FILES["Image"]["name"];
	$Target="Upload/".basename($_FILES["Image"]["name"]);  /// path where the image will upload
if (empty($Category)){
	$_SESSION["ErrorMessage"]="Title can't be empty";
	Redirect_to("AddNewPost.php");
	
}
elseif(strlen($Category)>99){
	$_SESSION["ErrorMessage"]="Title Should be at-least 2 Characters";
	Redirect_to("AddNewPost.php");
}
else{
	global $ConnectingDB;
	$Query="INSERT INTO admin_panel(dateandtime,title,category,author,image,post)
	VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
	$Execute=mysqli_query($ConnectingDB,$Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);   //  image uploading function
	if($Execute){
	$_SESSION["SuccessMessage"]="Post Added Successfully";
	Redirect_to("AddNewPost.php");
	}else{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("AddNewPost.php");
		
	}
	
}
}
	
?> 
<!DOCTYPE>
<html>
<html>
	<head>
		<title>Admin Dashboard</title>
                <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
                <script src="vendor/js/jquery-3.2.1.min.js"></script>
                <script src="vendor/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="vendor/css/adminstyles.css">

                
	</head>

<body>

<div class="container-fluid">
	<div class="row">
	<div class="col-sm-2">
	<h1>ADMIN PANEL</h1>
	<br><br>
	<ul id="Side_Menu" class="nav nav-pills nav-stacked">
	<li>
	<a href="Dashboard.php">
	<span class="glyphicon glyphicon-th"></span>
	&nbsp;Dashboard</a></li>
	<li class="active"><a href="AddNewPost.php">
	<span class="glyphicon glyphicon-list-alt"></span>
	&nbsp;Add New Post</a></li>
	<li ><a href="Categories.php">
	<span class="glyphicon glyphicon-tags"></span>
	&nbsp;Categories</a></li>
	<li><a href="Admins.php">
	<span class="glyphicon glyphicon-user"></span>
	&nbsp;Manage Admins</a></li>
	<li><a href="Comments.php">
	<span class="glyphicon glyphicon-comment"></span>
	&nbsp;Comments
<?php
$ConnectingDB;
$QueryTotal="SELECT COUNT(*) FROM comments WHERE status='OFF'";
$ExecuteTotal=mysqli_query($ConnectingDB,$QueryTotal);
$RowsTotal=mysqli_fetch_array($ExecuteTotal);
$Total=array_shift($RowsTotal);
if($Total>0){
?>
<span class="label pull-right label-warning">
<?php echo $Total;?>
</span>
		
<?php } ?></a>
	</li>
	<li><a href="Blog.php?Page=1" target="_Blank">
	<span class="glyphicon glyphicon-equalizer"></span>
	&nbsp;Live Blog</a></li>
	<li><a href="Logout.php">
	<span class="glyphicon glyphicon-log-out"></span>
	&nbsp;Logout</a></li>	
		
	</ul>
	
	</div> <!-- Ending of Side area -->
	
	<div class="col-sm-10">
	<h1>Add New Post </h1>
	<div> <?php echo Message(); echo SuccessMessage();?> </div>
<form action="AddNewPost.php" method="post" enctype="multipart/form-data">
	<fieldset>
	<div class="form-group">
	<label for="title"><span class="FieldInfo">Title:</span></label>
	<input class="form-control" type="text" name="Title" id="title" placeholder="Title">
	</div>
	<div class="form-group">
	<label for="categoryselect"><span class="FieldInfo">Category:</span></label>
	<select class="form-control" id="categoryselect" name="Category" >
	<?php
global $ConnectingDB;
$ViewQuery="SELECT * FROM category ORDER BY id desc";
$Execute=mysqli_query($ConnectingDB,$ViewQuery);
while($DataRows=mysqli_fetch_array($Execute)){
	$Id=$DataRows["id"];
	$CategoryName=$DataRows["name"];
?>	
	<option><?php echo $CategoryName; ?></option>
	<?php } ?>
			
	</select>
	</div>
	<div class="form-group">
	<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
	<input type="File" class="form-control" name="Image" id="imageselect">
	</div>
	<div class="form-group">
	<label for="postarea"><span class="FieldInfo">Post:</span></label>
	<textarea class="form-control" name="Post" id="postarea"></textarea>
	<br>
<input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post">
	</fieldset>
	<br>
</form>

<?php
global $ConnectingDB;
$ViewQuery="SELECT * FROM category ORDER BY dateandtime desc";
$Execute=mysqli_query($ConnectingDB ,$ViewQuery);

while($DataRows=mysqli_fetch_array($Execute)){
	$CategoryName=$DataRows["name"];
		} 
		?>	


	
	</div> <!-- ending of main -->
</div>  <!-- ending of row -->
</div>  <!-- container fluid -->
</body>

</html>