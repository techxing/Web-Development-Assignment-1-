<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assignment_style.css">

    <title>Post Status Process PHP </title>
  </head>

  <div class="content">
    <body>

      <?php
// import data base connection information.


  require_once 'conf/sqlinfo.inc.php';
// assign variable to server connectoin.
    $conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db) or die("<p>Server connection failed !</p>");

// check database connection.

  if (!$conn) {
      echo "database connection failure, please try again";
  } else {

    // Assign variable for input get from the status posting form.
      $Status_Code =$_POST["statuscode"];
      $Status = $_POST["status"];
      $Dates =$_POST["date"];
      $Share = $_POST["share"];
      $Permission = $_POST["permission"];
      $Permissiontype  = implode(",", $Permission);

      //valiate status code not null
      if (!empty($Status_Code)) {

        // set status code pattern as per assignemnt requriement.
          $statusCodePattern = "/^S\d\d\d\d$/";

          //validate user input for status code to match with parttern set above
          if (preg_match($statusCodePattern, $Status_Code)) {
              if (!empty($Status)) {
                  // set status  pattern as per assignemnt requriement.
                  $statusPattern = "/[\w \s,\.!\?]+/";

                  //validate user status input to match with parttern set above
                  if (preg_match($statusPattern, $Status)) {

                    // set status  pattern as per assignemnt requriement.
                      $datePattern = "/^\d{1,2}\/\d{1,2}\/\d{4}$/";
                      // grab data for day, month and year.
                      $day = substr($Dates, 0, 2);
                      $month = substr($Dates, 3, 2);
                      $year = substr($Dates, 6);

                      //validate user date input to match with parttern set above and use checkdate function from PHP.
                      if (preg_match($datePattern, $Dates)&& checkdate($day, $month, $year)) {

                        // check if table exist or not.
                          $checkTableQuery = "SHOW TABLES LIKE 'poststatus'";
                          $result = @mysqli_query($conn, $checkTableQuery);
                          if (mysqli_num_rows($result)>0) {
                              echo "Table 'poststatus' already exist !";
                          } else {
                              // create table is no table dose not exist.
                              $createTableQuey = "CREATE TABLE poststatus (Status_Code (10) NOT NULL PRIMARY KEY, Status VARCHAR (140) NOT Null, Share VARCHAR (20),Dates (20) NOT Null, Permission VARCHAR(50))";
                              $result = @mysqli_query($conn, $createTableQuey);
                              echo "Post Status Table has been created";
                          }
                          // assign variable to poststatus table.
                          $sql_tble = "poststatus";

                          $insertQuery = "INSERT INTO $sql_tble (Status_Code, Status, Share, Dates, Permission) values ('$Status_Code', '$Status', '$Share', '$Dates', '$Permissiontype' )";

                          //this is // DEBUGGing code
                          echo $insertQuery;
                          // executes the query
                          $result = mysqli_query($conn, $insertQuery);
                          // checks if the execution was successful, if not provide user with error message.
                          if (!$result) {
                              echo "<p>Something is wrong with ",	$insertQuery, "</p>";
                              echo "<p><a href='index.html'> Return to Home page </a></p>";
                              echo "<p> <a href='poststatusform.php'>Return to Post Status page</a></p>";
                          } else {
                              echo "<p> Your status post have been saved </p>";
                              echo "<p><a href='index.html'> Return to Home page </a></p>";
                              echo "<p> <a href='poststatusform.php'>Return to Post Status page</a></p>";
                          }

                          // free up memory after input.
                          mysqli_free_result($result);
                          // close connection after input.
                          mysqli_close($conn);
                      } else {
                          //privde error mesg if user's date input does not met requirment.
                          echo "Please double check your input date and follow date format dd/mm/yyyy";
                          echo "<p><a href='index.html'> Return to Home page </a></p>";
                          echo "<p> <a href='poststatusform.php'>Return to Post Status page</a></p>";
                      }
                  } else {
                      //privde error mesg if user's status input does not met requirment. provide link back to home back and post status page.

                      echo "Status input is not valid, The status can only contain alphanumeric characters including spaces, comma, period (full stop), exclamation point and question mark. Other characters or symbols are not allowed. ";
                      echo "<p><a href='index.html'> Return to Home page </a></p>";
                      echo "<p> <a href='poststatusform.php'>Return to Post Status page</a></p>";
                  }
              } else {
                  //privde error mesg if users status input is null. provide link back to home back and post status page.

                  echo "No input for Status";
                  echo "<p><a href='index.html'> Return to Home page </a></p>";
                  echo "<p> <a href='poststatusform.php'>Return to Post Status page</a></p>";
              }
          } else {
              //privde error mesg if users status code input formate does not meet requriment. provide link back to home back and post status page.
              echo "Your Status Code is not valid please follow 'S0001' format";
              echo "<p><a href='index.html'> Return to Home page </a></p>";
              echo "<p> <a href='poststatusform.php'>Return to Post Status page</a></p>";
          }
      } else {
          //privde error mesg if users status code input is null. provide link back to home back and post status page.

          echo "Status Code is not filled";
          echo "<p><a href='index.html'> Return to Home page </a></p>";
          echo "<p> <a href='poststatusform.php'>Return to Post Status page</a></p>";
      }
  }

?>

    </body>

  </div>

</html>
