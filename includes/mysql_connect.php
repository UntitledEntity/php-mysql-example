<?php

$mysql_link = mysqli_connect("localhost", "interzgk_public", "AadHggVtSf!!Y8Q", "interzgk_main");

if ($mysql_link == false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
