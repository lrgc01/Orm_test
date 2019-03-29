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
?>

