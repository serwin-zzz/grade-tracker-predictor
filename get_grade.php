<html>
<head>
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            width: 400;
        }
        th, td {
            align-content: center;
            padding: 5px;
        }
    </style>
</head>
<body>
<?php
$conn = mysqli_connect("localhost", "root", "");
if(!$conn) {
    die ("Error connecting to MySQL: " . mysqli_error($conn));
}

$db_select =  mysqli_select_db($conn, "modulesdb");
if(!$db_select) {
    die ("Error selecting database: ". mysqli_error($conn));
}

if (!($_POST['mid'] == 'all')) {
    $sql_get_module = "SELECT * FROM modules WHERE mid = '" . $_POST['mid'] . "'";

    $sql_get_avg_marks = "SELECT AVG(mark) AS avg FROM assessments
                          WHERE mid = '" . $_POST['mid'] . "'";

    $sql_get_assess = "SELECT * FROM assessments 
                       WHERE mid = '" . $_POST['mid'] ."'";

    if (!$module_details = mysqli_query($conn, $sql_get_module)) {
        die('Error: ' . mysqli_error($conn));
    }

    if (!$avg_marks = mysqli_query($conn, $sql_get_avg_marks)) {
        die('Error: ' . mysqli_error($conn));
    }

    if (!$assess_details = mysqli_query($conn, $sql_get_assess)) {
        die('Error: ' . mysqli_error($conn));
    }

    $module_details_array = mysqli_fetch_array($module_details);

    $avg_marks_result = mysqli_fetch_array($avg_marks);

    echo "<h1> " . $module_details_array['mid'] . " " . $module_details_array['mod_name'] . " </h1>";

    $degree_class = "Bad";
    if ($avg_marks_result['avg'] >= 70) {
        $degree_class = "First-class";
    } elseif ($avg_marks_result['avg'] >= 60) {
        $degree_class = "2:1";
    } elseif ($avg_marks_result['avg'] >= 50) {
        $degree_class = "2:2";
    }

    echo "<p> Projected degree-class based on performance: " . $degree_class . " </p>";
    echo "<p> Average so far: " . $avg_marks_result['avg'] . " </p>";

    echo "<table border = '1'>";
    echo "<tr><th> Code </th> <th> Name </th> <th> Mark </th></tr>";
    while ($assess_details_array = mysqli_fetch_array($assess_details)) {
        echo "<tr>";
        echo "<td>" . $assess_details_array['mid'] . "</td>";
        echo "<td>" . $assess_details_array['assess_name'] . "</td>";
        echo "<td>" . $assess_details_array['mark'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h1> Year 2 BSc Computer Science with Year in Industry </h1>";

    $sql_get_all_avg = "SELECT avg(mark) AS avg FROM assessments GROUP BY mid";
    $all_avg = mysqli_query($conn, $sql_get_all_avg);
    $count = 0;
    $total_avg = 0;
    while ($all_avg_array = mysqli_fetch_array($all_avg)) {
        $count = $count + 1;
        $total_avg = $total_avg + $all_avg_array['avg'];
    }

    $degree_avg = $total_avg / $count;
    $degree_class = "Bad";
    if ($degree_avg >= 70) {
        $degree_class = "First-class";
    } elseif ($degree_avg >= 60) {
        $degree_class = "2:1";
    } elseif ($degree_avg >= 50) {
        $degree_class = "2:2";
    }

    echo "<p> Projected degree-class based on performance: " . $degree_class . "</p>";
    echo "<p> Average so far: " . $degree_avg . " </p>";

    $all_modules = mysqli_query($conn, "SELECT mid FROM modules");

    while ($all_modules_array = mysqli_fetch_array($all_modules)) {
        echo "<table border = '1'>";
        echo "<tr><td></td><th>" . $all_modules_array['mid'] . "</th><td></td></tr>";

        $sql_get_assess = "SELECT * FROM assessments 
                           WHERE mid = '" . $all_modules_array['mid'] ."'";
        $assess_details = mysqli_query($conn, $sql_get_assess);
        while ($assess_details_array = mysqli_fetch_array($assess_details)) {
            echo "<tr'>";
            echo "<td >" . $assess_details_array['mid'] . "</td>";
            echo "<td>" . $assess_details_array['assess_name'] . "</td>";
            echo "<td>" . $assess_details_array['mark'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</br>";
    }
}
?>

</body>
</html>