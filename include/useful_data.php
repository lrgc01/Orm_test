<?php
// Some useful data
echo "<I>This HTTP server host: </I>" . $_SERVER['HTTP_HOST'] . " - ";
echo "<I>This server local address: </I>" . $_SERVER['SERVER_ADDR'] . " - ";
echo "<I>Time of the request: </I>" . date("D M j G:i:s T Y", $_SERVER['REQUEST_TIME']) . "</ BR>";
?>

