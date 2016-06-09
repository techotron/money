<html>
<head>
<title>Money Spent</title>

  <link rel="stylesheet" href="./jquery/jquery-ui.css">
  <script src="./jquery/jquery-1.10.2.js"></script>
  <script src="./jquery/jquery-ui.js"></script>
  <link rel="stylesheet" type="text\css" href="./style.css"> 
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>

</head>

<body>

<form name=money action="insert.php" method="post">
<div id="label">


Item: <br><br>
Amount Paid: <br><br>
 Date: <br><br>

</div>

<div id='textbox'>

</select>

<input type='text' name='item' id='item'><br><br>

<!-- <textarea cols='50' rows='5' name='amountPaid' id='amountPaid'></textarea><br><br> -->

<input type='number' min='0.01' step='0.01' max='2500' name='amountPaid' id='amountPaid'><br><br>

<input type='text' name='datepicker' id='datepicker'>

</div>

<br><br><br><br><br><br><br><br>



<input type="submit" value="Save"><br>
</form>

</body>
</html>

