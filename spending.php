<html>
<head>
<title>Monthly Spending</title>
</head>

<body>

<?php
// Connection -----------------------------------------------
$config = parse_ini_file('../../mysqlConnections/MoneyConnection.ini');
$connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
$currMonth =  sprintf('%02d', (int)date('m'));	// Get current date format in MM - convert to integer type
$currMonthSingle = date('n');			// Get current date format in M
$currMonthWord = date('F');

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Table selection parameters -------------------------------

// So far, this only displays a drop down box with the months - selecting them does nothing interesting yet.
$monthQuery = "SELECT month FROM months ORDER BY numericalValue = '" . $currMonthSingle . "' DESC, numericalValue";
$monthResults = mysqli_query($connection, $monthQuery);

echo "<form method='get'>";
echo "Select Month: <select name='months'>";

while($month = mysqli_fetch_array($monthResults)) {
	echo "<option value='" . $month['month'] . "'>" . $month['month'] . "</option>";
}

echo "</select>  <input type='submit' value='Go'><br><br>";

if (isset($_GET['months'])) {

  $selectedMonth = $_GET['months'];
  echo "Selected Month: " . $selectedMonth;

} else {

  $selectedMonth = $currMonthWord;
  echo "Selected Month: " . $selectedMonth;

}

echo "</form>";

// Table ----------------------------------------------------
// SQL result for table:
$sqlResults = "SELECT * FROM results ORDER BY datePaid DESC";
$results = mysqli_query($connection, $sqlResults);


// Calculate total spent:
//$sqlSum = "SELECT SUM(amountPaid) AS sumTotal FROM results";	//Calculates total of entire table
$sqlSum = "SELECT SUM(amountPaid) AS sumTotal FROM results WHERE DATE_FORMAT(datePaid, '%M') = '" . $selectedMonth . "'";	//Calculates total of current month only
$sum = mysqli_fetch_assoc(mysqli_query($connection, $sqlSum));

echo "<table border='1' cellpadding='3' cellspacing='1'";
echo "<tr><th> Item Purchased </th><th> Amount Paid </th><th> Date Purchased </th></tr>";

if (isset($_GET['months'])) {

  while($row = mysqli_fetch_array($results)) {

    if (date('F', strtotime($row['datePaid'])) == $selectedMonth) {	// Note date is expressed here in word format

      echo "<tr><td>" . $row['item'] . "</td><td>" . $row['amountPaid'] . "</td><td>" . $row['datePaid'] . "</td></tr>";

    }

  }

} else {

  while($row = mysqli_fetch_array($results)) {
 
    if (date('m', strtotime($row['datePaid'])) == $currMonth) {		// Note date is expressed here is MM format

      echo "<tr><td>" . $row['item'] . "</td><td>" . $row['amountPaid'] . "</td><td>" . $row['datePaid'] . "</td></tr>";

    }

  }

}

echo "</table><br>";

echo "Total Spent this Month: £" . $sum['sumTotal'];

?>

</body>
</html>
