<?php require_once("include/db.php")?>
<?php require_once("include/sessions.php")?> 
<?php require_once("include/functions.php")?> 
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
	$Admin ="zia";
	$Image=$_FILES["Image"]["name"];
	$Target="upload/".basename($_FILES["Image"]["name"]);  /// path where the image will upload
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
	$EditFromURL=$_GET['Edit'];
	$Query="UPDATE admin_panel SET dateandtime='$DateTime', title='$Title',
	category='$Category', author='$Admin',image='$Image',post='$Post'
	WHERE id='$EditFromURL'";
	
	$Execute=mysqli_query($ConnectingDB,$Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
	if($Execute){
	$_SESSION["SuccessMessage"]="Post Updated Successfully";
	Redirect_to("Dashboard.php");
	}else{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Dashboard.php");
		
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
	&nbsp;Comments</a>
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
	<div>
			<?php
	$SerachQueryParameter=$_GET['Edit'];
	$ConnectingDB;
	$Query="SELECT * FROM admin_panel WHERE id='$SerachQueryParameter'";
	$ExecuteQuery=mysqli_query($ConnectingDB,$Query);
	while($DataRows=mysqli_fetch_array($ExecuteQuery)){
		$TitleToBeUpdated=$DataRows['title'];
		$CategoryToBeUpdated=$DataRows['category'];
		$ImageToBeUpdated=$DataRows['image'];
		$PostToBeUpdated=$DataRows['post'];
		
	}
	
	
	?>
	
	<form action="EditPost.php?Edit=<?php echo $SerachQueryParameter; ?>" method="post" enctype="multipart/form-data">
	<fieldset>
	<div class="form-group">
	<label for="title"><span class="FieldInfo">Title:</span></label>
	<input value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
	</div>
		<div class="form-group">
	<span class="FieldInfo"> Existing Category: </span>
	<?php echo $CategoryToBeUpdated;?>
	<br>
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
		<span class="FieldInfo"> Existing Image: </span>
	<img src="upload/<?php echo $ImageToBeUpdated;?>" width=170px; height=70px;>
	<br>
	<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
	<input type="File" class="form-control" name="Image" id="imageselect">
	</div>

		<div class="form-group">
	<label for="postarea"><span class="FieldInfo">Post:</span></label>
	<textarea class="form-control" name="Post" id="postarea">
		<?php echo $PostToBeUpdated; ?>
	</textarea>
	</div>
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
	</div>
	</div> <!-- table -->
	
</div>  <!-- main -->
</div>  <!-- ROW -->
</div>  <!-- container fluid -->
</body>

</html>