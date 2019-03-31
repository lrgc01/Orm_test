<?php
// Here some PHP funcions
function my_filter_args()
{
	$arg_filter = array (
		'name'       => array(
			             'filter' => FILTER_SANITIZE_STRING,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
		'favColor'   => array(
			             'filter' => FILTER_SANITIZE_STRING,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
		'catsOrDogs' => array(
			             'filter' => FILTER_SANITIZE_STRING,
			             'flags'  => FILTER_REQUIRE_SCALAR,
				),
		'delList'    => array(
			             'filter' => FILTER_VALIDATE_INT,
			             'flags'  => FILTER_REQUIRE_ARRAY,
				),
	);
	return $arg_filter;
}

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

function data_to_delete($my_conn,$delList)
{
	if ($delList != NULL) {
	   $OR_clause = "DELETE FROM mainData WHERE id=" . my_input_filter($delList[0]);
	   for ($i = 1 ; $i < sizeof($delList) ; $i++) {
		$id = my_input_filter($delList[$i]);
		$OR_clause = $OR_clause . " or id=" . $id;
	   }
	   //print "<p> " . $OR_clause . "</p>\n";
           $delete_stmt = $my_conn->prepare($OR_clause);
           $delete_stmt->execute(); // Execute the statement.
	}
}

function print_current_data($my_conn)
{
   print "<HR><P>Current data:</P>\n";

   $select_stmt = $my_conn->prepare("select name, favColor, catsOrDogs, id from mainData");
   $select_stmt->execute(); // Execute the statement.
   $result = $select_stmt->get_result(); // Binds the last executed statement as a result.
         
   print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"1\">\n <tbody>\n";
   echo "   <thead>
      <tr>
        <th>Name</th>
        <th>Favorite Color</th>
        <th>Cats or Dogs</th>
        <th>Check to Delete</th>
      </tr>
    </thead>
";

   // Fetch the Associative Array
   while ($row = $result->fetch_assoc())
   {   
       echo "     <tr>";
       print " <td>" . $row["name"] . "</td>  ";
       print " <td>" . $row["favColor"] . "</td>  ";
       print " <td>" . $row["catsOrDogs"] . "</td>  ";
       print " <td>" . "<input type=\"checkbox\" name=\"delList[]\" value=\"" . $row["id"] . "\">" . "</td>  ";
       print "\n    <tr>\n";
       //var_dump($row);
   }
   print "     <tr>\n     <td></td><td></td><td></td>\n     <td><input type=\"submit\" value=\"Submit\">\n     </td></tr>\n";
   print "   </tbody>\n  </table>\n";

}

?>
