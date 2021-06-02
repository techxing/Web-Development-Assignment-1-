<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="assignment_style.css">

    <title> Status Posting System </title>

  </head>

  <div class="Content">

  <body>



<?php
// import data base connection information.

require_once 'conf/sqlinfo.inc.php';
// assign variable to server connectoin.
$conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db) or die("<p>datebase connection failed !</p>");

if (!$conn) {
    echo "database connection failure";
}

 ?>

 <div class = "header">
  <h1> Status Posting System</h1>
  <p> User Status Posting Function</p>
 </div>

<div class = "form" text-align = "center" >
 <form method="post"  action="poststatusprocess.php">
   <p>	<label for="statuscode"><b>Status Code (required)</b>: </label>
     <input type="text" name="statuscode" id="statuscode" /></p>

   <p>	<label for="status"><b>Status (required)</b>: </label>
     <input type="text" name="status" id="status" /></p>


   <p>
     <label for="share"><b>Share:</b></label>
     <input type="radio" name="share" value="public" id = "share"/>
     <label for="public"> Public</label>
     <input type="radio" name="share" value="friends" id = "share" />
     <label for="friends"> Friends</label>
     <input type="radio" name="share" value="onlyme" id = "share"/>
     <label for="onlyme"> Only Me</label>
    </p>


   <p>
     <label for="date"><b>Date (dd/mm/yyyy):</b></label>

     <?php
     // set system date to a variable
     $currentday = date("d/m/y");

      ?>
     <input type="text" name="date" id="date" value = "<?php echo $currentday; ?>"> </p>


     <p>
       <label for="permission[]"> <b>Permission Type: </b></label>
       <input type="checkbox" name="permission[]" value="Allow like" id = "permission[]"/> Allow Like
       <input type="checkbox" name="permission[]" value="Allow comment" id = "permission[]"/> Allow Comment
       <input type="checkbox" name="permission[]" value="Allow share" id = "permission[]"/> Allow Share
    </p>

    <p> <input type="submit" value="Submit" />
        <input type="reset" value="Reset" />  </p>

  </form>
</div>
  <div class = "navbar">
    <p><a class="active" href="index.html">Home Page</a> </p>
    <p><a href="poststatusform.php">Post a new status </a> </p>
    <p><a href="searchstatusform.html">Search status </a>  </p>
    <p><a href="about.html" class = "right">About this assignment </a></p>

  </div>

  <footer>

  <p>Created by Oscar Xing for COMP721 Web Development</p>

  </footer>
    </body>

  </div>
</html>
