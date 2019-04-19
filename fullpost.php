<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/captcha.php"); ?>
<?php
Global $ConnectingDB;
if(isset($_POST["Submit"])){
$Name=mysqli_real_escape_string($ConnectingDB, $_POST["Name"]);  // preventing sql injection
$Email=mysqli_real_escape_string($ConnectingDB,$_POST["Email"]);
$Comment=mysqli_real_escape_string($ConnectingDB,$_POST["Comment"]);
$captchaResult=mysqli_real_escape_string($ConnectingDB,$_POST["captchaResult"]);
date_default_timezone_set("Asia/Dhaka");
$CurrentTime=time();
//$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
$DateTime=strftime("%d-%B-%Y %H:%M:%S",$CurrentTime);
$DateTime;
$PostId=$_GET["id"];

$checkTotal =$_POST["firstNumber"] + $_POST["secondNumber"];  /// catcha total

if((empty($Name)||empty($Email) ||empty($Comment))||empty($captchaResult)){
	$_SESSION["ErrorMessage"]="All Fields are required";
	
}elseif(strlen($Comment)>500){
	$_SESSION["ErrorMessage"]="only 500  Characters are Allowed in Comment";
	
}elseif($captchaResult!=$checkTotal){
	$_SESSION["ErrorMessage"]="Captcha Failed";

}else{
	global $ConnectingDB;
	$PostIDFromURL=$_GET['id'];
        $Query="INSERT into comments (dateandtime,name,email,comments,status,admin_panel_id)
	VALUES ('$DateTime','$Name','$Email','$Comment','OFF','$PostIDFromURL')";
	$Execute=mysqli_query($ConnectingDB,$Query);
	if($Execute){
	$_SESSION["SuccessMessage"]="Comment Submitted Successfully";
	Redirect_to("FullPost.php?id={$PostId}");
	}else{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("FullPost.php?id={$PostId}");
		
	}
	
}	
	
}

?>

<!DOCTYPE>

<html>
	<head>
		<title>Full Blog Post</title>
                <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
                <script src="vendor/js/jquery-3.2.1.min.js"></script>
                <script src="vendor/js/bootstrap.min.js"></script>
				<link rel="stylesheet" href="vendor/css/publicstyles.css">
               <style>
		

nav ul li{
    float: left;
}.FieldInfo{
    color: rgb(251, 174, 44);
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-size: 1.2em;
}
.CommentBlock{
background-color:#F6F7F9;
}
.Comment-info{
	color: #365899;
	font-family: sans-serif;
	font-size: 1.1em;
	font-weight: bold;
	padding-top: 10px;
        
	
}
.comment{
    margin-top:-2px;
    padding-bottom: 10px;
    font-size: 1.1em
}

	       </style> 
	</head>
	<body>
<div style="height: 10px; background: #27aae1;"></div>
<nav class="navbar navbar-inverse" role="navigation">
	<div class="container">
		<div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
		data-target="#collapse">
		<span class="sr-only">Toggle Navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

		</div>
		<div class="collapse navbar-collapse" id="collapse">
		<ul class="nav navbar-nav">
			<li><a href="#">Home</a></li>
			<li class="active"><a href="Blog.php">Blog</a></li>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Contact Us</a></li>
			<li><a href="#">Feature</a></li>
		</ul>
		<form action="blog.php" class="navbar-form navbar-right">
		<div class="form-group">
		<input type="text" class="form-control" placeholder="Search" name="Search" >
		</div>
	         <button class="btn btn-default" name="SearchButton">Go</button>
			
		</form>
		</div>
		
	</div>
</nav>
<div class="Line" style="height: 10px; background: #27aae1;"></div>
<div class="container"> <!--Container-->
	<div class="blog-header">
	<h1>Total Blog  </h1>
	<p class="lead">The Complete blog using PHP</p>
	</div>
	<div class="row"> <!--Row-->
		<div class="col-sm-8"> <!--Main Blog Area-->
			<?php echo Message();
	      echo SuccessMessage();
	?>
		<?php
		global $ConnectingDB;
		// Query when Search Button is Active
		if(isset($_GET["SearchButton"])){
			$Search=$_GET["Search"];
			
		$ViewQuery="SELECT * FROM admin_panel
		WHERE dateandtime LIKE '%$Search%' OR title LIKE '%$Search%'    
		OR category LIKE '%$Search%' OR post LIKE '%$Search%'";   // % sign is important to grab before and after
		}else{
			$idfromurl=$_GET["id"];
		$ViewQuery="SELECT * FROM admin_panel WHERE id ='$idfromurl' ORDER BY dateandtime	desc";}
		$Execute=mysqli_query($ConnectingDB,$ViewQuery);
		while($DataRows=mysqli_fetch_array($Execute)){
			$PostId=mysqli_real_escape_string($ConnectingDB,$DataRows["id"]);
			$DateTime=mysqli_real_escape_string($ConnectingDB,$DataRows["dateandtime"]);
			$Title=mysqli_real_escape_string($ConnectingDB,$DataRows["title"]);
			$Category=mysqli_real_escape_string($ConnectingDB,$DataRows["category"]);
			$Admin=mysqli_real_escape_string($ConnectingDB,$DataRows["author"]);
			$Image=mysqli_real_escape_string($ConnectingDB,$DataRows["image"]);
		$Post=mysqli_real_escape_string($ConnectingDB,$DataRows["post"]);
			
		
		?>
		<div class="blogpost thumbnail">
			<img class="img-responsive img-rounded"src="Upload/<?php echo $Image;  ?>" >
		<div class="caption">
			<h1 id="heading"> <?php echo htmlentities($Title); ?></h1>
		<p class="description">Category:<?php echo htmlentities($Category); ?> Published on
		<?php echo htmlentities($DateTime);?>

		</p>
		<p class="post"><?php echo nl2br($Post); ?></p>   <!--  nl2br is for formating test  -->
		</div>
			
		</div>
		<?php } ?>
				<br><br>
		<span class="FieldInfo">Comments</span>
<?php
$ConnectingDB;
$PostIdForComments=$_GET["id"];
$ExtractingCommentsQuery="SELECT * FROM comments WHERE admin_panel_id='$PostIdForComments' AND status='ON' ";
$Execute=mysqli_query($ConnectingDB,$ExtractingCommentsQuery);
while($DataRows=mysqli_fetch_array($Execute)){
	$CommentDate=$DataRows["dateandtime"];
	$CommenterName=$DataRows["name"];
	$Comments=$DataRows["comments"];


?>
<div class="CommentBlock">
	<img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" width=70px; height=70px;>
	<p style="margin-left: 90px; word-wrap:break-word;" class="Comment-info"><?php echo $CommenterName; ?></p>
	<p style="margin-left: 90px;word-wrap:break-word;"class="description"><?php echo $CommentDate; ?></p>
	<p style="margin-left: 90px;word-wrap:break-word;" class="Comment"><?php echo nl2br($Comments); ?></p>
	
</div>

	<hr>
<?php } ?>
		<br>
		<span class="FieldInfo">Share your thoughts about this post</span>
		
		
<form action="FullPost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
	<fieldset>
	<div class="form-group">
	<label for="Name"><span class="FieldInfo">Name</span></label>
	<input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
	</div>
	<div class="form-group">
	<label for="Email"><span class="FieldInfo">Email</span></label>
	<input class="form-control" type="email" name="Email" id="Email" placeholder="email">
	</div>
	<div class="form-group">
	<label for="commentarea"><span class="FieldInfo">Comment</span></label>
	<textarea class="form-control" name="Comment" id="commentarea"></textarea>
	<br>
		</div> 
			<div class="form-group">
	<label for="captcha"><span class="FieldInfo">Are you human ?</span></label><br>
	<?php
			echo $random_number1 . ' + ' . $random_number2 . ' = ';
		?>
		<input name="captchaResult" id="captchaResult" type="text" size="2" />

		<input name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
		<input name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" />
	<br>
		</div> 
<input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
	</fieldset>
	<br>
</form>
		

			</div> <!--  ending main blog -->

	
		<div class="col-sm-offset-1 col-sm-3"> <!--Side Area -->
			<h2>About me </h2>	
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit
		, sed do eiusmod tempor incididunt ut labore et dolore magna
		aliqua. Ut enim ad minim veniam, quis nostrud exercitation ul
		lamco laboris nisi ut aliquip ex ea commodo consequat. Duis a
		ute irure dolor in reprehenderit in voluptate velit esse cill
		um dolore eu fugiat nulla pariatur. Excepteur sint occaecat c
		upidatat non proi
		dent, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			
		</div> <!--Side Area Ending-->
	</div> <!--Row Ending-->
	
	
</div><!--Container Ending-->


	    
	</body>
</html>