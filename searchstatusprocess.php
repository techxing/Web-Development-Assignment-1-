<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assignment_style.css">
    <title>Search Status Process</title>
  </head>

  <div class ="content">

  <body>
<div class = "header">
<h1> Status Information </h1>
<p> Display user's search result</p>
</div>
<?php

// import data base connection information.
require_once('conf/sqlinfo.inc.php');
// assign variable to server connectoin.
$conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db) or die("<p>Server connection failed !</p>");


// check datebase connection
if (!$conn) {
    echo "database connection failure, please try again";
} else {

  //check it data base connection debug code - echo"successful";

    //validate table existence
    $queryValidateTable = "SHOW TABLES LIKE 'poststatus'";
    $resultTable = @mysqli_query($conn, $queryValidateTable);

    if (mysqli_num_rows($resultTable)>0) {


        //Get Search input from the seach status form
        $searchStatus = $_GET["Search"];

        // assgin variable to sql table
        $sql_tble = "poststatus";
        // set sql query to select search from the database table
        $query = "SELECT * from $sql_tble where Status like '$searchStatus%'";
        $result = mysqli_query($conn, $query);


        // validte above sql query
        if (!$result) {
            echo"<p> somthing is wrong with ", $query, "</p>";
            echo "<p><a href='index.html'> Return to Home page </a></p>";
            echo "<p> <a href='searchstatusform.html'>Return to Search Post Status page</a></p>";
        } else {
            //validate search input, not null.
            if (!empty($searchStatus)) {

              // set search status pattern
                $statusPattern = "/[\w \s,\.!\?]+/";
                // validate search status pattern, if not match privder error mesg to user.
                if (!preg_match($statusPattern, $searchStatus)) {
                    echo "Status input is not valid, The status can only contain alphanumeric characters including spaces, comma, period (full stop), exclamation point and question mark. Other characters or symbols are not allowed. ";

                    echo "<p> <a href='searchstatusform.html'>Return to Search Post Status page</a></p>";
                } else {

                    // validate search status exist or not if not provid user with feedback
                    if (mysqli_num_rows($result) <1) {
                        echo"the Status you are looking for dose not exist, please try again";
                        echo "<p> <a href='searchstatusform.html'>Return to Search Post Status page</a></p>";
                    } else {

                      // display searched status with it associate input as well .
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo"<p> <b>Status:</b> ", $row["Status"], "</p>";
                            echo"<p> <b>Status Code:</b> ", $row ["Status_Code"], "</p>";
                            echo " ";
                            echo"<p> <b>Share:</b> ", $row["Share"], "</p>";
                            echo"<p><b>Date Posted:</b> ", $row["Dates"], "</p>";
                            echo"<p><b>Permission:</b> ", $row["Permission"], "</p>";
                        }
                    }
                }
            } else {
                echo"please enter the status you want to search";

                // free up the result after search
                mysqli_free_result($result);
            }
        }
    }

    // close connection.
    mysqli_close($conn);
}
?>




<div class="navbar">
  <p><a href="index.html">Back to Home page </a> </p>
  <p><a href="poststatusform.php">Post a new status </a> </p>
  <p><a href="searchstatusform.html">Search status </a> </p>
  <p><a href="about.html">About this assignment </a></p>

</div>

  </body>
</div>
</html>
