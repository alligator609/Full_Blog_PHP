<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>
<?php
if(isset($_GET["id"])){
    $IdFromURL=$_GET["id"];
    $ConnectingDB;
$Query="DELETE FROM category WHERE id='$IdFromURL' ";
$Execute=mysqli_query($ConnectingDB,$Query);
if($Execute){
	$_SESSION["SuccessMessage"]="Category Deleted Successfully";
	Redirect_to("Categories.php");
	}else{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("Categories.php");
		
	}
    
    
    
    
    
}

?>