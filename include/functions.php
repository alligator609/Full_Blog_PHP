<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/DB.php"); ?>

<?php 
function Redirect_to($New_Location){
	header("Location:".$New_Location);
	exit;
}
function Login_Attempt($Username,$Password){
    Global $ConnectingDB;  // have to use global in function
    $Query="SELECT * FROM registration WHERE username='$Username' AND password='$Password'";
    $Execute=mysqli_query($ConnectingDB,$Query);
    if($admin=mysqli_fetch_assoc($Execute)){
	return $admin;
    }else{
	return null;
    }
}
function Login(){
    if(isset($_SESSION["User_Id"])){
	return true;
    }
}
 function Confirm_Login(){
    if(!Login()){
	$_SESSION["ErrorMessage"]="Login Required ! ";
	Redirect_to("Login.php");
    }
    
 }
?> 