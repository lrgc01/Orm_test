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

<body>
<H2>Enter your data</H2>
<HR>

<?php
require_once("include/useful_data.php");
require_once("include/myfunctions.php");
?>

<?php
// Use base function 'my_input_filter' to do a preliminary cleaning
// The same 'my_input_filter' function certifies that '$name' is not null
$name       = my_input_filter($_POST['name']);
$favColor   = my_input_filter($_POST['favColor']);
$catsOrDogs = my_input_filter($_POST['catsOrDogs']);
?>

<HR>
<!--
Name: <?php echo $name; ?><br />
Favorite Color: <?php echo $favColor; ?><br />
Cats or dogs: <?php echo $catsOrDogs; ?><br />
<br />
-->

<form action="form.php" method="post">
<table border="0" cellpadding="5" cellspacing="1">
 <tbody>
  <tr>
   <td> Name:           </td> <td> <input type="text" name="name" /></td>
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

<HR>

<?php
   // Just load database settings
   require_once("include/test_db_settings.php");

   $mysqli_conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

   if ($name != '') 
   {
      $id = check_name($mysqli_conn,$name);
   
      if ($id != 0) {
         // Prepare statement and execute
         $update_stmt = $mysqli_conn->prepare("UPDATE mainData set name=?, favColor=?, catsOrDogs=? WHERE id=?");
         $update_stmt->bind_param("sssi", $name, $favColor, $catsOrDogs, $id); 
         $update_stmt->execute(); 
   
      } else {
   
         // Prepare statement and execute
         $insert_stmt = $mysqli_conn->prepare("INSERT INTO mainData (id, name, favColor, catsOrDogs) values ('', ?, ?, ?)");
         $insert_stmt->bind_param("sss", $name, $favColor, $catsOrDogs); 
         $insert_stmt->execute(); 
      }
   }

   print_current_data($mysqli_conn);

   $mysqli_conn->close();
?>

</body>
</html>

