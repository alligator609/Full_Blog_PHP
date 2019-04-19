<?php require_once("include/db.php")?> \
<?php require_once("include/sessions.php")?> 
<?php require_once("include/functions.php")?> 
<?php confirm_Login(); ?>
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
	<li class="active">
	<a href="Dashboard.php">
	<span class="glyphicon glyphicon-th"></span>
	&nbsp;Dashboard</a></li>
	<li><a href="AddNewPost.php">
	<span class="glyphicon glyphicon-list-alt"></span>
	&nbsp;Add New Post</a></li>
	<li><a href="categories.php">
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
	<h1>ADMIN</h1>
	<div> <?php echo Message(); echo SuccessMessage();?> </div>
	<div class="table-responsive">
	<table class="table table-striped table-hover">
		<tr>
			<th>No</th>
			<th>Post Title</th>
			<th>Date &Time</th>
			<th>Author</th>
			<th>Category</th>
			<th>Banner</th>
			<th>Comments</th>
			<th>Action</th>
			<th>Details</th>
			
		</tr>
	<?php
$ConnectingDB;
$ViewQuery="SELECT * FROM admin_panel ORDER BY id desc;";
$Execute=mysqli_query($ConnectingDB,$ViewQuery);
$SrNo=0;
while($DataRows=mysqli_fetch_array($Execute)){
	$Id=$DataRows["id"];
	$DateTime=$DataRows["dateandtime"];
	$Title=$DataRows["title"];
	$Category=$DataRows["category"];
	$Admin=$DataRows["author"];
	$Image=$DataRows["image"];
	$Post=$DataRows["post"];
	$SrNo++;
	?>
	<tr>
		
	<td><?php echo $SrNo; ?></td>
	<td style="color: #5e5eff;"><?php
	if(strlen($Title)>19){$Title=substr($Title,0,19).'..';}
	echo $Title;
	?></td>
	<td><?php
	if(strlen($DateTime)>12){$DateTime=substr($DateTime,0,12);}
	echo $DateTime;
	?></td>
	<td><?php
	if(strlen($Admin)>9){$Admin=substr($Admin,0,9);}
	echo $Admin; ?></td>
	<td><?php
	if(strlen($Category)>10){$Category=substr($Category,0,10);}
	echo $Category;
	?></td>
	<td><img src="Upload/<?php echo $Image; ?>" width="170px"; height="50px"></td>
	<td>
		<?php
$ConnectingDB;
$QueryApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='ON'";
$ExecuteApproved=mysqli_query($ConnectingDB,$QueryApproved);
$RowsApproved=mysqli_fetch_array($ExecuteApproved);
$TotalApproved=array_shift($RowsApproved);  // moving all array into one array
if($TotalApproved>0){
?>
<span class="label pull-right label-success">
<?php echo $TotalApproved;?>
</span>
		
<?php } ?>

<?php
$ConnectingDB;
$QueryUnApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='OFF'";
$ExecuteUnApproved=mysqli_query($ConnectingDB,$QueryUnApproved);
$RowsUnApproved=mysqli_fetch_array($ExecuteUnApproved);
$TotalUnApproved=array_shift($RowsUnApproved);  // moving all array into one array
if($TotalUnApproved>0){
?>
<span class="label  label-danger">
<?php echo $TotalUnApproved;?>
</span>
		
<?php } ?>
	</td>
	<td>
	<a href="EditPost.php?Edit=<?php echo $Id; ?>">
	<span class="btn btn-warning">Edit</span>
	</a>
	<a href="DeletePost.php?Delete=<?php echo $Id; ?>">
	<span class="btn btn-danger">Delete</span>
	</a>
	</td>
	<td>
	<a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank">
	<span class="btn btn-primary"> Live Preview</span>
	</a>
	</td>
	</tr>
	<?php } ?>
	</table>
</div>
	
	</div> <!-- ending of main -->
</div>  <!-- ending of row -->
</div>  <!-- container fluid -->
</body>

</html>
