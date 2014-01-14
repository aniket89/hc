<html>
<body>

<?php

ini_set('display_errors', 1);
error_reporting(~0);

$con=mysqli_connect("127.0.0.1","root","animalkingdom","healthcode");
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM login_master where username = '" . $_POST["name"] . "' and password='" . $_POST["password"] . "'");
$logged_in = false;
while($row = mysqli_fetch_array($result))
{
	$logged_in = true;
	$user_type = $row ['type'];
}

if ($logged_in == false) {
	   header( 'Location: http://127.0.0.1/login.php' ) ;
}else {
	$username = $_POST["name"];
	$result = mysqli_query($con,"select * from user_info where login_id = (select login_id from login_master where username = '" . $username . "')");
	while($row = mysqli_fetch_array($result))
	{
		$fullname = $row['first_name'] . " " . $row['last_name'];
		$address = $row ['address'];
		$age = $row ['age'];
		$contact_num = $row ['contact_num'];
		$blood_group = $row ['blood_group'];
		$sex = $row ['sex'];
	}
	$result = mysqli_query ($con, "select * from patient_medical_record where login_id = (select login_id from login_master where username = '" . $username . "');"
	while ($row = mysqli_fetch_array ($result)) {
		$wbc = $row['wbc'];
		$rbc = $row['rbc'];
	}
?>

Welcome <?php echo $_POST["name"]; ?><br>
Your password is: <?php echo $_POST["password"]; ?><br><br><br>
	
<form action="view_info.php" method="post">
	<input type="hidden" name="type" value="<?=$user_type?>">
	<input type="hidden" name="fullname" value="<?=$fullname?>">
	<input type="hidden" name="address" value="<?=$address?>">
	<input type="hidden" name="age" value="<?=$age?>">
	<input type="hidden" name="sex" value="<?=$sex?>">
	<input type="hidden" name="blood_group" value="<?=$blood_group?>">
	<a href="javascript:;" onclick="parentNode.submit ()">View Personal Info</a><br>
</form>
<?php
$type = 1;
if ($type == 1) {
?>
<form action="" method="post">
<a href="javascript:;" onclick="parentNode.submit ()">Search Doctor </a> <br>
</form>
<form action="" method="post">
<a href="javascript:;" onclick="parentNode.submit ()">View Medical History </a> <br>
</form>
<?php
} else {
?>
<form action="" method="post">
<a href="javascript:;" onclick="parentNode.submit ()">Search for Doctors / Patients </a> <br>
</form>
<form action="view_info.php" method="post">
<a href="javascript:;" onclick="parentNode.submit ()">View Medical record Of Patients </a> <br>
</form>
<?php
}
}
?>
</body>
</html>