<?php
$conn = mysqli_connect("localhost", "root", "");
if(!$conn) {
    die ("Error connecting to MySQL: " . mysqli_error($conn));
}

$db_select =  mysqli_select_db($conn, "modulesdb");
if(!$db_select) {
    die ("Error selecting database: ". mysqli_error($conn));
}

$sql_insert = "INSERT INTO assessments (mid, assess_name, mark) 
VALUES('$_POST[mid]','$_POST[assess_name]','$_POST[mark]')";

if (!mysqli_query($conn, $sql_insert)) {
    die('Error: ' . mysqli_error($conn));
} else {
    echo "<h1> Module assessment has been added. </h1>";
}

mysqli_close($conn);
?>