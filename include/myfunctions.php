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

// This one should be called after my_input_filter
function check_name($my_conn,$name)
{
   $sel_stmt = $my_conn->prepare("SELECT name,id FROM mainData WHERE name=?");
   $sel_stmt->bind_param("s", $name); 
   $sel_stmt->execute(); 

   $result = $sel_stmt->get_result(); // Binds the last executed statement as a result.
   $row = $result->fetch_assoc();

   //echo "<p>DEBUG: " . $row["name"] . ", " . $row["id"] . ".</p>";
   //var_dump($row);
   if (strcmp($row["name"],$name) == 0 )
     {
        return $row["id"];
     } else {
        return 0;
     }

}

function print_current_data($mysqli_conn)
{
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

}

?>
