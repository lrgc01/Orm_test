<html>

<style type="text/css">table{
   display: block;
   overflow-x: auto;
   white-space: nowrap;
   width: 95%;
   background-color: #eeeeee;
   margin-left:auto; 
   margin-right:auto;
}
</style>


<title>Technical Test</title>
<body>

<H1>Technical Test</H1>

<HR>

<?php
require_once("include/useful_data.php");
?>

<HR>

<form action="form.php" method="post">
<table border="0" cellpadding="5" cellspacing="1">
 <tbody>
  <tr>
   <td> Name: 		</td> <td> <input type="text" name="name" /></td>
  </tr>
  <tr>
   <td> Favorite Color: </td> <td> <input type="text" name="favColor" /></td>
  </tr>
  <tr>
   <td> Cats or Dogs:   </td> <td> <input type="text" name="catsOrDogs" /></td>
  </tr>
 </tbody>
</table>

<p><input type="submit" value="Submit"></p>
</form>

<?php
require_once("include/test_db_settings.php");
require_once("include/myfunctions.php");

$mysqli_conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

print_current_data($mysqli_conn);

$mysqli_conn->close();

?>

</body>
</html>
