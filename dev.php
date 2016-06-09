<html>
<head>
<title>*** DEV - Monthly Spending ***</title>
</head>

<body>
<h1>*** DEV SITE ***</h1>
<?php
// Connection -----------------------------------------------
$config = parse_ini_file('../../mysqlConnections/MoneyConnection.ini');
$connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
$currMonth =  sprintf('%02d', (int)date('m'));	// Get current date format in MM - convert to integer type

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Table selection parameters -------------------------------

// So far, this only displays a drop down box with the months - selecting them does nothing interesting yet.
$monthQuery = "SELECT month FROM months ORDER BY numericalValue";
$monthResults = mysqli_query($connection, $monthQuery);

echo "<form action='#' method='get'>";
echo "Select Month: <select name='months'>";

while($month = mysqli_fetch_array($monthResults)) {
	echo "<option value='" . $month['month'] . "'>" . $month['month'] . "</option>";
}

echo "</select> ";

echo "<input type='submit' name='submit' value='Go!' />";
echo "</form><br>";


if(isset($_GET['submit'])) {

  //$selectedMonth = $_GET['months']; // I've left this here for future reference
  //$convertedMonth = date('m', strtotime($selectedMonth)); // I've left this here for future reference
  $selectedMonth = date('m', strtotime($_GET['months']));
  $selectedMonthStr = $_GET['months'];
  echo $selectedMonthStr . "<br><br>";

}

// Table ----------------------------------------------------
// SQL result for table:
$sqlResults = "SELECT * FROM results ORDER BY datePaid DESC";
$results = mysqli_query($connection, $sqlResults);

// Calculate total spent:
//$sqlSum = "SELECT SUM(amountPaid) AS sumTotal FROM results";	//Calculates total of entire table

//$sqlSum = "SELECT SUM(amountPaid) AS sumTotal FROM results WHERE MONTH(datePaid) = MONTH(CURRENT_DATE)";	//Calculates total of current month only
//$sum = mysqli_fetch_assoc(mysqli_query($connection, $sqlSum));

echo "<table border='1' cellpadding='3' cellspacing='1'";
echo "<tr><th> Item Purchased </th><th> Amount Paid </th><th> Date Purchased </th></tr>";

if (isset($_GET['submit'])) {

  while($row = mysqli_fetch_array($results)) {

    if (date('m', strtotime($row['datePaid'])) == $selectedMonth) {

      echo "<tr><td>" . $row['item'] . "</td><td>" . $row['amountPaid'] . "</td><td>" . $row['datePaid'] . "</td></tr>";
      $sqlSum = "SELECT SUM(amountPaid) AS sumTotal FROM results WHERE MONTH(datePaid) = " . $selectedMonth;
      $sum = mysqli_fetch_assoc(mysqli_query($connection, $sqlSum));

    }

  }

} else {

  while($row = mysqli_fetch_array($results)) {

    if (date('m', strtotime($row['datePaid'])) == $currMonth) {

      echo "<tr><td>" . $row['item'] . "</td><td>" . $row['amountPaid'] . "</td><td>" . $row['datePaid'] . "</td></tr>";
      $sqlSum = "SELECT SUM(amountPaid AS sumTotal FROM results WHERE MONTH(datePaid) = MONTH(CURRENT_DATE)";
      $sum = mysqli_fetch_assoc(mysqli_query($connection, $sqlSum));

    }

  }

}

echo "</table><br>";

echo "Total Spent this Month: £" . $sum['sumTotal'];

?>

</body>
</html>
