<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php
if(isset($_GET["id"])){
    $IdFromURL=$_GET["id"];
    $ConnectingDB;
    //$Admin=$_SESSION["Username"];
$Query="UPDATE comments SET status='OFF' WHERE id='$IdFromURL' ";
$Execute=mysqli_query($ConnectingDB,$Query);
if($Execute){
	$_SESSION["SuccessMessage"]="Comment Dis-Approved Successfully";
	Redirect_to("Comments.php");
	}else{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Comments.php");
		
	}
    
}

?>