<?php
// Use base function 'my_input_filter' to do a preliminary cleaning
$name       = my_input_filter($_POST['name'],"You must provide some content to the required field: Name.");
$favColor   = my_input_filter($_POST['favColor']);
$catsOrDogs = my_input_filter($_POST['catsOrDogs']);
?>

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
<H2>Your data</H2>
Name: <?php echo $name; ?><br />
Favorite Color: <?php echo $favColor; ?><br />
Cats or dogs: <?php echo $catsOrDogs; ?><br />
<br />

<?php
   // Just load database settings
   require_once("ormuco-test_db_settings.php");

   // The 'my_input_filter' function certifies that '$name' is not null
   $mysqli_conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
           
   // Prepare statement and execute
   $insert_stmt = $mysqli_conn->prepare("INSERT INTO mainData (id, name, favColor, catsOrDogs) values ('', ?, ?, ?)");
   $insert_stmt->bind_param("sss", $name, $favColor, $catsOrDogs); 
   $insert_stmt->execute(); 

   echo "<HR><P>Current data:</P>";

   $select_stmt = $mysqli_conn->prepare("select name, favColor, catsOrDogs from mainData");
   $select_stmt->execute(); // Execute the statement.
   $result = $select_stmt->get_result(); // Binds the last executed statement as a result.
         
   echo "<table border=\"0\" cellpadding=\"5\" cellspacing=\"1\">
    <tbody>";
   echo "   <thead>
      <tr>
        <th>Name</th>
        <th>Favorite Color</th>
        <th>Cats or Dogs</th>
      </tr>
    </thead>";

   // Fetch the Associative Array
   while ($row = $result->fetch_assoc())
   {   
       echo "<tr>";
       foreach ($row as $r)
          {
              print "<td>$r</td>  ";
          }
       print "\n<tr>\n";
       //var_dump($row);
   }
   echo "   </tbody>
</table>";

   $mysqli_conn->close();
?>

</body>
</html>

<?php
// Here some PHP funcions
function my_input_filter($data, $reqMessage='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($reqMessage && strlen($data) == 0)
    {
        die($reqMessage);
    }
    return $data;
}
?>

