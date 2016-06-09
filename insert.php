<?php

$config = parse_ini_file('../../mysqlConnections/MoneyConnection.ini');

$con = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

echo 'Connected successfully<br>';
//echo $_POST[datepicker];
//$changedate = DateTime::createFromFormat('m/d/Y', $_POST['datepicker']);

$item = "$_POST[item]";
$item1 = mysqli_real_escape_string($con, $title);
// This doesn't work - perhaps dueo the MySQL version?

$sql="INSERT INTO results (id, item, amountPaid, datePaid)
VALUES
(NULL, '" . $item . "', '$_POST[amountPaid]', '$_POST[datepicker]')";

if (!mysqli_query($con,$sql))
	{
		die('Error: ' . mysqli_error($con));
	}
echo "1 record added";

mysqli_close($con);

?>

<form>
<input type="button" value="Back" onclick="location.href='./index.php'">
</form>
