<?php require_once("include/db.php");?>
<?php require_once("include/sessions.php");?> 
<?php require_once("include/functions.php");?> .
<?php confirm_login(); ?>
<?php 
if(isset($_POST["Submit"])){
	$Categorys=$_POST["Category"];
	date_default_timezone_set("Asia/Dhaka");
	$CurrentTime=time();
/*

*/
	$DateTime=strftime("%d-%B-%Y %H:%M:%S",$CurrentTime);
	echo $DateTime;
	$Admin =$_SESSION["Username"];
if (empty($Categorys)){
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("categories.php");
	
}
elseif(strlen($Categorys)>99){
	$_SESSION["ErrorMessage"]="Too long Name for Category";
	Redirect_to("categories.php");
	
}
else{
	global $ConnectingDB;
	$Query="INSERT INTO category(dateandtime,name,creatorname)VALUES('$DateTime','$Categorys','$Admin')";
	$Execute=mysqli_query($ConnectingDB, $Query);
	if($Execute){
	$_SESSION["SuccessMessage"]="Category Added Successfully";
	Redirect_to("categories.php");
	}else{
	$_SESSION["ErrorMessage"]="Category failed to Add";
	Redirect_to("categories.php");
		
	}
}
}
	
?> 
<!DOCTYPE>
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
	<li><a href="AddNewPost.php">
	<span class="glyphicon glyphicon-list-alt"></span>
	&nbsp;Add New Post</a></li>
	<li class="active"><a href="Categories.php">
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
	<h1>Manage Categories </h1>
	<div> <?php echo Message(); echo SuccessMessage();?> </div>
<form action="categories.php" method="post">
	<fieldset>
	<div class="form-group">
	<label for="categoryname"><span class="FieldInfo">Name:</span></label>
	<input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
	</div>
	<br>
<input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Category">
	</fieldset>
	<br>
</form>

<div class="table-responsive">
	<table class="table table-striped table-hover">
	<tr>
		<th>Sr No.</th>
		<th>Date & Time</th>
		<th>Category Name</th>
		<th>Creator Name</th>
		<th>Action</th>

		
	</tr>
<?php
global $ConnectingDB;
$ViewQuery="SELECT * FROM category ORDER BY dateandtime desc";
$Execute=mysqli_query($ConnectingDB ,$ViewQuery);
$SrNo=0;
while($DataRows=mysqli_fetch_array($Execute)){
	$Id=mysqli_real_escape_string($ConnectingDB,$DataRows["id"]);
	$DateTime=mysqli_real_escape_string($ConnectingDB,$DataRows["dateandtime"]);
	$CategoryName=mysqli_real_escape_string($ConnectingDB,$DataRows["name"]);
	$CreatorName=mysqli_real_escape_string($ConnectingDB,$DataRows["creatorname"]);
	$SrNo++;


	
	


?>
<tr>
	<td><?php echo $SrNo; ?></td>
	<td><?php echo $DateTime; ?></td>
	<td><?php echo $CategoryName; ?></td>
	<td><?php echo $CreatorName; ?></td>
	<td><a href="DeleteCategory.php?id=<?php echo $Id;?>">
	<span class="btn btn-danger">Delete</span>
	</a></td>
</tr>
		
	<?php } ?>	
	</table>
</div>
	
	</div> <!-- ending of main -->
</div>  <!-- ending of row -->
</div>  <!-- container fluid -->
</body>

</html>
