<!-- This is the PHP code for interpretating the login data provided by the user -->
<?php 
   include('dbh.php');
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css.calender/style_login_page.css"/>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- This is the link for the css file that does not exist yet -->
      <head>
         <meta charset="utf-8">
         <title> Login to Queens ProCode</title>
   </head>
   <body>
      <form action="login_page.php"  id = "login-form" class="container" method ="POST">
         <div class="login-banner">
            <div class ="login-box">
               <h1> Login into  Queens ProCode</h1>
               <div class="textbox">
                  <input type="text" placeholder="Email" name="user">
               </div>
               <div class="textbox">
                  <input type="password" placeholder="Password" name="passw" >
               </div>
               <div id="type">
                  <select name="typeuser">
                     <option> Student </option>
                     <option> Tutor</option>
                  </select>
               </div>
               <button class ="btn" name="submit" type="submit"> Login!</button>
      </form>
      <?php
         // This is the code that will check if the student or tutor is registered for the application
         // If the user hits the login button. The file will be directed here
         
         
         if (isset($_POST['submit'])){
           // There are the VARs captured by the form tag that exists above. 
           $username = $_POST['user'];
           $passw = $_POST['passw'];
           $type = $_POST['typeuser'];
           $userid = null;
           
           // if the type is equal to the string "Student" then follow this logic. 
           if ($type == 'Student') {
             
           // This will check if the $username variable is filled in. 
             if(empty($_POST['user'])) {
               
               // if the VAR is empty then return this message to the user. 
               echo '<p> <style> p {color:red;} </style> Username is empty <br/></p>';;
               
             } else{
               // else do nothing and continue with the logic
               
               
             }
             
             // check the password is empty
             $empty=true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style> Password is empty <br/></p>';
               
               
             } else {
               
             // if the the password is not empty return the value as false. 
             $empty=false;
               
             }
             
             
             
             
             if ($empty === false) {
               
               // grab the data from the database to verify the log in
               $auth = "SELECT * FROM student_details WHERE student_email = '$username' OR student_email = '$username' ";
               // execute the query
               $result = $conn->query($auth);
               // get the number of rows from the sql statement above
               $numrows = $result->num_rows;
               
               // if there is an issue with the sql query alert me 
               if(!$result){
                 
                 echo $conn->error;
                 
               }
               
               
               
               //Get the password from the while loop
               while($rowPassword = $result->fetch_assoc()) {
                 $getPassword=$rowPassword['student_password'];
                 
               }
               
               
               // check if the number of rows retured is more than 0 and that the password that has been returned is equal to the password that has been passed 
               // by the form tag. 
               if ($numrows > 0 && $getPassword == $passw  ) {
                 // get the tutor id again 
                 $getId = "SELECT student_id FROM student_details WHERE student_email = '$username'";
                 $result2= $conn->query($getId);
                 //echo $getId;  
                 while ($row=$result2->fetch_assoc()) {
                   
                   $userid = $row['student_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['student_id'] = $userid;
                 $session = $_SESSION['student_id'];
                 //echo $session;
                 //echo 'Login successful';
                 header('Location: student_homepage.php?successful');
                 
               } else {
                 
                 // if there is not data found set this statment 
                 echo '<p> <style> p {color:red;} </style> Username or Password invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
             
             
             
             
             
             // if the user hits tutor follow this route
           } else if ($type == 'Tutor') {
             echo 'Check 1';
             
             
             
             
             //check username is empty
             
             if(empty($_POST['user'])) {
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Username is empty <br/></p>';
               
               
               
               
             } else{
               
               
             }
             
             // check the password is empty
             $empty = true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Password is empty <br/></p>';
             } else {
               // otherwise set this var used for verification
               $empty=false;
               
             }
             
             
             
             
             
             // If teh error checks or passed assert the sql statement
             if ($empty == false) {
               
               $auth2 = "SELECT * FROM tutor_details WHERE tutor_email = '$username' ";
               
               // execute the sql statement 
               $result2 = $conn->query($auth2);
               $numrows = $result2->num_rows;
               echo $numrows;
               //echo $auth;
               
               
               
               
               
               
               // if there is a error tell me 
               if(!$result2){
                 
                 echo $conn->error;
                 
               }
               
               
               // Get the password from a while loop 
               
               while($rowPassword = $result2->fetch_assoc()) {
                 $getPassword =$rowPassword['tutor_password'];
                 
               }
               
               
               // if the number of rows returned is over 0 and the password matches
               if ($numrows > 0 && $getPassword == $passw ) {
                 
                 // get the tutor id again 
                 $getId = "SELECT tutor_id FROM tutor_details WHERE tutor_email = '$username'";
                 $result3 = $conn->query($getId);
                 echo $getId;  
                 while ($row=$result3->fetch_assoc()) {
                   // get the tutor id
                   $userid = $row['tutor_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['tutor_id'] = $userid;
                 $session = $_SESSION['tutor_id'];
                 echo $session;
                 echo 'Login successful';
                 
                 // send them to the tutor profile 
                 header("Location: ../tutor_level/tutor_home.php?loginsuccessful");
                 
               } else {
                 
                 // set the error message
                 echo '<p> <style> p {color:red;} </style> Username or Password Invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
           }
         }
         
         
         
         ?>
      </div>
      </div>
   </body>
</html>
<!-- This is the PHP code for interpretating the login data provided by the user -->
<?php 
   include('dbh.php');
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css.calender/style_login_page.css"/>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- This is the link for the css file that does not exist yet -->
      <head>
         <meta charset="utf-8">
         <title> Login to Queens ProCode</title>
   </head>
   <body>
      <form action="login_page.php"  id = "login-form" class="container" method ="POST">
         <div class="login-banner">
            <div class ="login-box">
               <h1> Login into  Queens ProCode</h1>
               <div class="textbox">
                  <input type="text" placeholder="Username" name="user">
               </div>
               <div class="textbox">
                  <input type="password" placeholder="Password" name="passw" >
               </div>
               <div id="type">
                  <select name="typeuser">
                     <option> Student </option>
                     <option> Tutor</option>
                  </select>
               </div>
               <button class ="btn" name="submit" type="submit"> Login!</button>
      </form>
      <?php
         // This is the code that will check if the student or tutor is registered for the application
         // If the user hits the login button. The file will be directed here
         
         
         if (isset($_POST['submit'])){
           // There are the VARs captured by the form tag that exists above. 
           $username = $_POST['user'];
           $passw = $_POST['passw'];
           $type = $_POST['typeuser'];
           $userid = null;
           
           // if the type is equal to the string "Student" then follow this logic. 
           if ($type == 'Student') {
             
           // This will check if the $username variable is filled in. 
             if(empty($_POST['user'])) {
               
               // if the VAR is empty then return this message to the user. 
               echo '<p> <style> p {color:red;} </style> Username is empty <br/></p>';;
               
             } else{
               // else do nothing and continue with the logic
               
               
             }
             
             // check the password is empty
             $empty=true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style> Password is empty <br/></p>';
               
               
             } else {
               
             // if the the password is not empty return the value as false. 
             $empty=false;
               
             }
             
             
             
             
             if ($empty === false) {
               
               // grab the data from the database to verify the log in
               $auth = "SELECT * FROM student_details WHERE student_email = '$username' OR student_email = '$username' ";
               // execute the query
               $result = $conn->query($auth);
               // get the number of rows from the sql statement above
               $numrows = $result->num_rows;
               
               // if there is an issue with the sql query alert me 
               if(!$result){
                 
                 echo $conn->error;
                 
               }
               
               
               
               //Get the password from the while loop
               while($rowPassword = $result->fetch_assoc()) {
                 $getPassword=$rowPassword['student_password'];
                 
               }
               
               
               // check if the number of rows retured is more than 0 and that the password that has been returned is equal to the password that has been passed 
               // by the form tag. 
               if ($numrows > 0 && $getPassword == $passw  ) {
                 // get the tutor id again 
                 $getId = "SELECT student_id FROM student_details WHERE student_email = '$username'";
                 $result2= $conn->query($getId);
                 //echo $getId;  
                 while ($row=$result2->fetch_assoc()) {
                   
                   $userid = $row['student_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['student_id'] = $userid;
                 $session = $_SESSION['student_id'];
                 //echo $session;
                 //echo 'Login successful';
                 header('Location: student_homepage.php?successful');
                 
               } else {
                 
                 // if there is not data found set this statment 
                 echo '<p> <style> p {color:red;} </style> Username or Password invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
             
             
             
             
             
             // if the user hits tutor follow this route
           } else if ($type == 'Tutor') {
             echo 'Check 1';
             
             
             
             
             //check username is empty
             
             if(empty($_POST['user'])) {
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Username is empty <br/></p>';
               
               
               
               
             } else{
               
               
             }
             
             // check the password is empty
             $empty = true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Password is empty <br/></p>';
             } else {
               // otherwise set this var used for verification
               $empty=false;
               
             }
             
             
             
             
             
             // If teh error checks or passed assert the sql statement
             if ($empty == false) {
               
               $auth2 = "SELECT * FROM tutor_details WHERE tutor_email = '$username' ";
               
               // execute the sql statement 
               $result2 = $conn->query($auth2);
               $numrows = $result2->num_rows;
               echo $numrows;
               //echo $auth;
               
               
               
               
               
               
               // if there is a error tell me 
               if(!$result2){
                 
                 echo $conn->error;
                 
               }
               
               
               // Get the password from a while loop 
               
               while($rowPassword = $result2->fetch_assoc()) {
                 $getPassword =$rowPassword['tutor_password'];
                 
               }
               
               
               // if the number of rows returned is over 0 and the password matches
               if ($numrows > 0 && $getPassword == $passw ) {
                 
                 // get the tutor id again 
                 $getId = "SELECT tutor_id FROM tutor_details WHERE tutor_email = '$username'";
                 $result3 = $conn->query($getId);
                 echo $getId;  
                 while ($row=$result3->fetch_assoc()) {
                   // get the tutor id
                   $userid = $row['tutor_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['tutor_id'] = $userid;
                 $session = $_SESSION['tutor_id'];
                 echo $session;
                 echo 'Login successful';
                 
                 // send them to the tutor profile 
                 header("Location: ../tutor_level/tutor_home.php?loginsuccessful");
                 
               } else {
                 
                 // set the error message
                 echo '<p> <style> p {color:red;} </style> Username or Password Invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
           }
         }
         
         
         
         ?>
      </div>
      </div>
   </body>
</html>
<!-- This is the PHP code for interpretating the login data provided by the user -->
<?php 
   include('dbh.php');
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css.calender/style_login_page.css"/>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- This is the link for the css file that does not exist yet -->
      <head>
         <meta charset="utf-8">
         <title> Login to Queens ProCode</title>
   </head>
   <body>
      <form action="login_page.php"  id = "login-form" class="container" method ="POST">
         <div class="login-banner">
            <div class ="login-box">
               <h1> Login into  Queens ProCode</h1>
               <div class="textbox">
                  <input type="text" placeholder="Username" name="user">
               </div>
               <div class="textbox">
                  <input type="password" placeholder="Password" name="passw" >
               </div>
               <div id="type">
                  <select name="typeuser">
                     <option> Student </option>
                     <option> Tutor</option>
                  </select>
               </div>
               <button class ="btn" name="submit" type="submit"> Login!</button>
      </form>
      <?php
         // This is the code that will check if the student or tutor is registered for the application
         // If the user hits the login button. The file will be directed here
         
         
         if (isset($_POST['submit'])){
           // There are the VARs captured by the form tag that exists above. 
           $username = $_POST['user'];
           $passw = $_POST['passw'];
           $type = $_POST['typeuser'];
           $userid = null;
           
           // if the type is equal to the string "Student" then follow this logic. 
           if ($type == 'Student') {
             
           // This will check if the $username variable is filled in. 
             if(empty($_POST['user'])) {
               
               // if the VAR is empty then return this message to the user. 
               echo '<p> <style> p {color:red;} </style> Username is empty <br/></p>';;
               
             } else{
               // else do nothing and continue with the logic
               
               
             }
             
             // check the password is empty
             $empty=true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style> Password is empty <br/></p>';
               
               
             } else {
               
             // if the the password is not empty return the value as false. 
             $empty=false;
               
             }
             
             
             
             
             if ($empty === false) {
               
               // grab the data from the database to verify the log in
               $auth = "SELECT * FROM student_details WHERE student_email = '$username' OR student_email = '$username' ";
               // execute the query
               $result = $conn->query($auth);
               // get the number of rows from the sql statement above
               $numrows = $result->num_rows;
               
               // if there is an issue with the sql query alert me 
               if(!$result){
                 
                 echo $conn->error;
                 
               }
               
               
               
               //Get the password from the while loop
               while($rowPassword = $result->fetch_assoc()) {
                 $getPassword=$rowPassword['student_password'];
                 
               }
               
               
               // check if the number of rows retured is more than 0 and that the password that has been returned is equal to the password that has been passed 
               // by the form tag. 
               if ($numrows > 0 && $getPassword == $passw  ) {
                 // get the tutor id again 
                 $getId = "SELECT student_id FROM student_details WHERE student_email = '$username'";
                 $result2= $conn->query($getId);
                 //echo $getId;  
                 while ($row=$result2->fetch_assoc()) {
                   
                   $userid = $row['student_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['student_id'] = $userid;
                 $session = $_SESSION['student_id'];
                 //echo $session;
                 //echo 'Login successful';
                 header('Location: student_homepage.php?successful');
                 
               } else {
                 
                 // if there is not data found set this statment 
                 echo '<p> <style> p {color:red;} </style> Username or Password invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
             
             
             
             
             
             // if the user hits tutor follow this route
           } else if ($type == 'Tutor') {
             echo 'Check 1';
             
             
             
             
             //check username is empty
             
             if(empty($_POST['user'])) {
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Username is empty <br/></p>';
               
               
               
               
             } else{
               
               
             }
             
             // check the password is empty
             $empty = true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Password is empty <br/></p>';
             } else {
               // otherwise set this var used for verification
               $empty=false;
               
             }
             
             
             
             
             
             // If teh error checks or passed assert the sql statement
             if ($empty == false) {
               
               $auth2 = "SELECT * FROM tutor_details WHERE tutor_email = '$username' ";
               
               // execute the sql statement 
               $result2 = $conn->query($auth2);
               $numrows = $result2->num_rows;
               echo $numrows;
               //echo $auth;
               
               
               
               
               
               
               // if there is a error tell me 
               if(!$result2){
                 
                 echo $conn->error;
                 
               }
               
               
               // Get the password from a while loop 
               
               while($rowPassword = $result2->fetch_assoc()) {
                 $getPassword =$rowPassword['tutor_password'];
                 
               }
               
               
               // if the number of rows returned is over 0 and the password matches
               if ($numrows > 0 && $getPassword == $passw ) {
                 
                 // get the tutor id again 
                 $getId = "SELECT tutor_id FROM tutor_details WHERE tutor_email = '$username'";
                 $result3 = $conn->query($getId);
                 echo $getId;  
                 while ($row=$result3->fetch_assoc()) {
                   // get the tutor id
                   $userid = $row['tutor_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['tutor_id'] = $userid;
                 $session = $_SESSION['tutor_id'];
                 echo $session;
                 echo 'Login successful';
                 
                 // send them to the tutor profile 
                 header("Location: ../tutor_level/tutor_home.php?loginsuccessful");
                 
               } else {
                 
                 // set the error message
                 echo '<p> <style> p {color:red;} </style> Username or Password Invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
           }
         }
         
         
         
         ?>
      </div>
      </div>
   </body>
</html>
<!-- This is the PHP code for interpretating the login data provided by the user -->
<?php 
   include('dbh.php');
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css.calender/style_login_page.css"/>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- This is the link for the css file that does not exist yet -->
      <head>
         <meta charset="utf-8">
         <title> Login to Queens ProCode</title>
   </head>
   <body>
      <form action="login_page.php"  id = "login-form" class="container" method ="POST">
         <div class="login-banner">
            <div class ="login-box">
               <h1> Login into  Queens ProCode</h1>
               <div class="textbox">
                  <input type="text" placeholder="Username" name="user">
               </div>
               <div class="textbox">
                  <input type="password" placeholder="Password" name="passw" >
               </div>
               <div id="type">
                  <select name="typeuser">
                     <option> Student </option>
                     <option> Tutor</option>
                  </select>
               </div>
               <button class ="btn" name="submit" type="submit"> Login!</button>
      </form>
      <?php
         // This is the code that will check if the student or tutor is registered for the application
         // If the user hits the login button. The file will be directed here
         
         
         if (isset($_POST['submit'])){
           // There are the VARs captured by the form tag that exists above. 
           $username = $_POST['user'];
           $passw = $_POST['passw'];
           $type = $_POST['typeuser'];
           $userid = null;
           
           // if the type is equal to the string "Student" then follow this logic. 
           if ($type == 'Student') {
             
           // This will check if the $username variable is filled in. 
             if(empty($_POST['user'])) {
               
               // if the VAR is empty then return this message to the user. 
               echo '<p> <style> p {color:red;} </style> Username is empty <br/></p>';;
               
             } else{
               // else do nothing and continue with the logic
               
               
             }
             
             // check the password is empty
             $empty=true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style> Password is empty <br/></p>';
               
               
             } else {
               
             // if the the password is not empty return the value as false. 
             $empty=false;
               
             }
             
             
             
             
             if ($empty === false) {
               
               // grab the data from the database to verify the log in
               $auth = "SELECT * FROM student_details WHERE student_email = '$username' OR student_email = '$username' ";
               // execute the query
               $result = $conn->query($auth);
               // get the number of rows from the sql statement above
               $numrows = $result->num_rows;
               
               // if there is an issue with the sql query alert me 
               if(!$result){
                 
                 echo $conn->error;
                 
               }
               
               
               
               //Get the password from the while loop
               while($rowPassword = $result->fetch_assoc()) {
                 $getPassword=$rowPassword['student_password'];
                 
               }
               
               
               // check if the number of rows retured is more than 0 and that the password that has been returned is equal to the password that has been passed 
               // by the form tag. 
               if ($numrows > 0 && $getPassword == $passw  ) {
                 // get the tutor id again 
                 $getId = "SELECT student_id FROM student_details WHERE student_email = '$username'";
                 $result2= $conn->query($getId);
                 //echo $getId;  
                 while ($row=$result2->fetch_assoc()) {
                   
                   $userid = $row['student_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['student_id'] = $userid;
                 $session = $_SESSION['student_id'];
                 //echo $session;
                 //echo 'Login successful';
                 header('Location: student_homepage.php?successful');
                 
               } else {
                 
                 // if there is not data found set this statment 
                 echo '<p> <style> p {color:red;} </style> Username or Password invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
             
             
             
             
             
             // if the user hits tutor follow this route
           } else if ($type == 'Tutor') {
             echo 'Check 1';
             
             
             
             
             //check username is empty
             
             if(empty($_POST['user'])) {
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Username is empty <br/></p>';
               
               
               
               
             } else{
               
               
             }
             
             // check the password is empty
             $empty = true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Password is empty <br/></p>';
             } else {
               // otherwise set this var used for verification
               $empty=false;
               
             }
             
             
             
             
             
             // If teh error checks or passed assert the sql statement
             if ($empty == false) {
               
               $auth2 = "SELECT * FROM tutor_details WHERE tutor_email = '$username' ";
               
               // execute the sql statement 
               $result2 = $conn->query($auth2);
               $numrows = $result2->num_rows;
               echo $numrows;
               //echo $auth;
               
               
               
               
               
               
               // if there is a error tell me 
               if(!$result2){
                 
                 echo $conn->error;
                 
               }
               
               
               // Get the password from a while loop 
               
               while($rowPassword = $result2->fetch_assoc()) {
                 $getPassword =$rowPassword['tutor_password'];
                 
               }
               
               
               // if the number of rows returned is over 0 and the password matches
               if ($numrows > 0 && $getPassword == $passw ) {
                 
                 // get the tutor id again 
                 $getId = "SELECT tutor_id FROM tutor_details WHERE tutor_email = '$username'";
                 $result3 = $conn->query($getId);
                 echo $getId;  
                 while ($row=$result3->fetch_assoc()) {
                   // get the tutor id
                   $userid = $row['tutor_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['tutor_id'] = $userid;
                 $session = $_SESSION['tutor_id'];
                 echo $session;
                 echo 'Login successful';
                 
                 // send them to the tutor profile 
                 header("Location: ../tutor_level/tutor_home.php?loginsuccessful");
                 
               } else {
                 
                 // set the error message
                 echo '<p> <style> p {color:red;} </style> Username or Password Invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
           }
         }
         
         
         
         ?>
      </div>
      </div>
   </body>
</html>
<!-- This is the PHP code for interpretating the login data provided by the user -->
<?php 
   include('dbh.php');
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css.calender/style_login_page.css"/>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- This is the link for the css file that does not exist yet -->
      <head>
         <meta charset="utf-8">
         <title> Login to Queens ProCode</title>
   </head>
   <body>
      <form action="login_page.php"  id = "login-form" class="container" method ="POST">
         <div class="login-banner">
            <div class ="login-box">
               <h1> Login into  Queens ProCode</h1>
               <div class="textbox">
                  <input type="text" placeholder="Username" name="user">
               </div>
               <div class="textbox">
                  <input type="password" placeholder="Password" name="passw" >
               </div>
               <div id="type">
                  <select name="typeuser">
                     <option> Student </option>
                     <option> Tutor</option>
                  </select>
               </div>
               <button class ="btn" name="submit" type="submit"> Login!</button>
      </form>
      <?php
         // This is the code that will check if the student or tutor is registered for the application
         // If the user hits the login button. The file will be directed here
         
         
         if (isset($_POST['submit'])){
           // There are the VARs captured by the form tag that exists above. 
           $username = $_POST['user'];
           $passw = $_POST['passw'];
           $type = $_POST['typeuser'];
           $userid = null;
           
           // if the type is equal to the string "Student" then follow this logic. 
           if ($type == 'Student') {
             
           // This will check if the $username variable is filled in. 
             if(empty($_POST['user'])) {
               
               // if the VAR is empty then return this message to the user. 
               echo '<p> <style> p {color:red;} </style> Username is empty <br/></p>';;
               
             } else{
               // else do nothing and continue with the logic
               
               
             }
             
             // check the password is empty
             $empty=true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style> Password is empty <br/></p>';
               
               
             } else {
               
             // if the the password is not empty return the value as false. 
             $empty=false;
               
             }
             
             
             
             
             if ($empty === false) {
               
               // grab the data from the database to verify the log in
               $auth = "SELECT * FROM student_details WHERE student_email = '$username' OR student_email = '$username' ";
               // execute the query
               $result = $conn->query($auth);
               // get the number of rows from the sql statement above
               $numrows = $result->num_rows;
               
               // if there is an issue with the sql query alert me 
               if(!$result){
                 
                 echo $conn->error;
                 
               }
               
               
               
               //Get the password from the while loop
               while($rowPassword = $result->fetch_assoc()) {
                 $getPassword=$rowPassword['student_password'];
                 
               }
               
               
               // check if the number of rows retured is more than 0 and that the password that has been returned is equal to the password that has been passed 
               // by the form tag. 
               if ($numrows > 0 && $getPassword == $passw  ) {
                 // get the tutor id again 
                 $getId = "SELECT student_id FROM student_details WHERE student_email = '$username'";
                 $result2= $conn->query($getId);
                 //echo $getId;  
                 while ($row=$result2->fetch_assoc()) {
                   
                   $userid = $row['student_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['student_id'] = $userid;
                 $session = $_SESSION['student_id'];
                 //echo $session;
                 //echo 'Login successful';
                 header('Location: student_homepage.php?successful');
                 
               } else {
                 
                 // if there is not data found set this statment 
                 echo '<p> <style> p {color:red;} </style> Username or Password invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
             
             
             
             
             
             // if the user hits tutor follow this route
           } else if ($type == 'Tutor') {
             echo 'Check 1';
             
             
             
             
             //check username is empty
             
             if(empty($_POST['user'])) {
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Username is empty <br/></p>';
               
               
               
               
             } else{
               
               
             }
             
             // check the password is empty
             $empty = true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Password is empty <br/></p>';
             } else {
               // otherwise set this var used for verification
               $empty=false;
               
             }
             
             
             
             
             
             // If teh error checks or passed assert the sql statement
             if ($empty == false) {
               
               $auth2 = "SELECT * FROM tutor_details WHERE tutor_email = '$username' ";
               
               // execute the sql statement 
               $result2 = $conn->query($auth2);
               $numrows = $result2->num_rows;
               echo $numrows;
               //echo $auth;
               
               
               
               
               
               
               // if there is a error tell me 
               if(!$result2){
                 
                 echo $conn->error;
                 
               }
               
               
               // Get the password from a while loop 
               
               while($rowPassword = $result2->fetch_assoc()) {
                 $getPassword =$rowPassword['tutor_password'];
                 
               }
               
               
               // if the number of rows returned is over 0 and the password matches
               if ($numrows > 0 && $getPassword == $passw ) {
                 
                 // get the tutor id again 
                 $getId = "SELECT tutor_id FROM tutor_details WHERE tutor_email = '$username'";
                 $result3 = $conn->query($getId);
                 echo $getId;  
                 while ($row=$result3->fetch_assoc()) {
                   // get the tutor id
                   $userid = $row['tutor_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['tutor_id'] = $userid;
                 $session = $_SESSION['tutor_id'];
                 echo $session;
                 echo 'Login successful';
                 
                 // send them to the tutor profile 
                 header("Location: ../tutor_level/tutor_home.php?loginsuccessful");
                 
               } else {
                 
                 // set the error message
                 echo '<p> <style> p {color:red;} </style> Username or Password Invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
           }
         }
         
         
         
         ?>
      </div>
      </div>
   </body>
</html>
<!-- This is the PHP code for interpretating the login data provided by the user -->
<?php 
   include('dbh.php');
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css.calender/style_login_page.css"/>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- This is the link for the css file that does not exist yet -->
      <head>
         <meta charset="utf-8">
         <title> Login to Queens ProCode</title>
   </head>
   <body>
      <form action="login_page.php"  id = "login-form" class="container" method ="POST">
         <div class="login-banner">
            <div class ="login-box">
               <h1> Login into  Queens ProCode</h1>
               <div class="textbox">
                  <input type="text" placeholder="Username" name="user">
               </div>
               <div class="textbox">
                  <input type="password" placeholder="Password" name="passw" >
               </div>
               <div id="type">
                  <select name="typeuser">
                     <option> Student </option>
                     <option> Tutor</option>
                  </select>
               </div>
               <button class ="btn" name="submit" type="submit"> Login!</button>
      </form>
      <?php
         // This is the code that will check if the student or tutor is registered for the application
         // If the user hits the login button. The file will be directed here
         
         
         if (isset($_POST['submit'])){
           // There are the VARs captured by the form tag that exists above. 
           $username = $_POST['user'];
           $passw = $_POST['passw'];
           $type = $_POST['typeuser'];
           $userid = null;
           
           // if the type is equal to the string "Student" then follow this logic. 
           if ($type == 'Student') {
             
           // This will check if the $username variable is filled in. 
             if(empty($_POST['user'])) {
               
               // if the VAR is empty then return this message to the user. 
               echo '<p> <style> p {color:red;} </style> Username is empty <br/></p>';;
               
             } else{
               // else do nothing and continue with the logic
               
               
             }
             
             // check the password is empty
             $empty=true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style> Password is empty <br/></p>';
               
               
             } else {
               
             // if the the password is not empty return the value as false. 
             $empty=false;
               
             }
             
             
             
             
             if ($empty === false) {
               
               // grab the data from the database to verify the log in
               $auth = "SELECT * FROM student_details WHERE student_email = '$username' OR student_email = '$username' ";
               // execute the query
               $result = $conn->query($auth);
               // get the number of rows from the sql statement above
               $numrows = $result->num_rows;
               
               // if there is an issue with the sql query alert me 
               if(!$result){
                 
                 echo $conn->error;
                 
               }
               
               
               
               //Get the password from the while loop
               while($rowPassword = $result->fetch_assoc()) {
                 $getPassword=$rowPassword['student_password'];
                 
               }
               
               
               // check if the number of rows retured is more than 0 and that the password that has been returned is equal to the password that has been passed 
               // by the form tag. 
               if ($numrows > 0 && $getPassword == $passw  ) {
                 // get the tutor id again 
                 $getId = "SELECT student_id FROM student_details WHERE student_email = '$username'";
                 $result2= $conn->query($getId);
                 //echo $getId;  
                 while ($row=$result2->fetch_assoc()) {
                   
                   $userid = $row['student_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['student_id'] = $userid;
                 $session = $_SESSION['student_id'];
                 //echo $session;
                 //echo 'Login successful';
                 header('Location: student_homepage.php?successful');
                 
               } else {
                 
                 // if there is not data found set this statment 
                 echo '<p> <style> p {color:red;} </style> Username or Password invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
             
             
             
             
             
             // if the user hits tutor follow this route
           } else if ($type == 'Tutor') {
             echo 'Check 1';
             
             
             
             
             //check username is empty
             
             if(empty($_POST['user'])) {
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Username is empty <br/></p>';
               
               
               
               
             } else{
               
               
             }
             
             // check the password is empty
             $empty = true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Password is empty <br/></p>';
             } else {
               // otherwise set this var used for verification
               $empty=false;
               
             }
             
             
             
             
             
             // If teh error checks or passed assert the sql statement
             if ($empty == false) {
               
               $auth2 = "SELECT * FROM tutor_details WHERE tutor_email = '$username' ";
               
               // execute the sql statement 
               $result2 = $conn->query($auth2);
               $numrows = $result2->num_rows;
               echo $numrows;
               //echo $auth;
               
               
               
               
               
               
               // if there is a error tell me 
               if(!$result2){
                 
                 echo $conn->error;
                 
               }
               
               
               // Get the password from a while loop 
               
               while($rowPassword = $result2->fetch_assoc()) {
                 $getPassword =$rowPassword['tutor_password'];
                 
               }
               
               
               // if the number of rows returned is over 0 and the password matches
               if ($numrows > 0 && $getPassword == $passw ) {
                 
                 // get the tutor id again 
                 $getId = "SELECT tutor_id FROM tutor_details WHERE tutor_email = '$username'";
                 $result3 = $conn->query($getId);
                 echo $getId;  
                 while ($row=$result3->fetch_assoc()) {
                   // get the tutor id
                   $userid = $row['tutor_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['tutor_id'] = $userid;
                 $session = $_SESSION['tutor_id'];
                 echo $session;
                 echo 'Login successful';
                 
                 // send them to the tutor profile 
                 header("Location: ../tutor_level/tutor_home.php?loginsuccessful");
                 
               } else {
                 
                 // set the error message
                 echo '<p> <style> p {color:red;} </style> Username or Password Invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
           }
         }
         
         
         
         ?>
      </div>
      </div>
   </body>
</html>
<!-- This is the PHP code for interpretating the login data provided by the user -->
<?php 
   include('dbh.php');
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css.calender/style_login_page.css"/>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- This is the link for the css file that does not exist yet -->
      <head>
         <meta charset="utf-8">
         <title> Login to Queens ProCode</title>
   </head>
   <body>
      <form action="login_page.php"  id = "login-form" class="container" method ="POST">
         <div class="login-banner">
            <div class ="login-box">
               <h1> Login into  Queens ProCode</h1>
               <div class="textbox">
                  <input type="text" placeholder="Username" name="user">
               </div>
               <div class="textbox">
                  <input type="password" placeholder="Password" name="passw" >
               </div>
               <div id="type">
                  <select name="typeuser">
                     <option> Student </option>
                     <option> Tutor</option>
                  </select>
               </div>
               <button class ="btn" name="submit" type="submit"> Login!</button>
      </form>
      <?php
         // This is the code that will check if the student or tutor is registered for the application
         // If the user hits the login button. The file will be directed here
         
         
         if (isset($_POST['submit'])){
           // There are the VARs captured by the form tag that exists above. 
           $username = $_POST['user'];
           $passw = $_POST['passw'];
           $type = $_POST['typeuser'];
           $userid = null;
           
           // if the type is equal to the string "Student" then follow this logic. 
           if ($type == 'Student') {
             
           // This will check if the $username variable is filled in. 
             if(empty($_POST['user'])) {
               
               // if the VAR is empty then return this message to the user. 
               echo '<p> <style> p {color:red;} </style> Username is empty <br/></p>';;
               
             } else{
               // else do nothing and continue with the logic
               
               
             }
             
             // check the password is empty
             $empty=true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style> Password is empty <br/></p>';
               
               
             } else {
               
             // if the the password is not empty return the value as false. 
             $empty=false;
               
             }
             
             
             
             
             if ($empty === false) {
               
               // grab the data from the database to verify the log in
               $auth = "SELECT * FROM student_details WHERE student_email = '$username' OR student_email = '$username' ";
               // execute the query
               $result = $conn->query($auth);
               // get the number of rows from the sql statement above
               $numrows = $result->num_rows;
               
               // if there is an issue with the sql query alert me 
               if(!$result){
                 
                 echo $conn->error;
                 
               }
               
               
               
               //Get the password from the while loop
               while($rowPassword = $result->fetch_assoc()) {
                 $getPassword=$rowPassword['student_password'];
                 
               }
               
               
               // check if the number of rows retured is more than 0 and that the password that has been returned is equal to the password that has been passed 
               // by the form tag. 
               if ($numrows > 0 && $getPassword == $passw  ) {
                 // get the tutor id again 
                 $getId = "SELECT student_id FROM student_details WHERE student_email = '$username'";
                 $result2= $conn->query($getId);
                 //echo $getId;  
                 while ($row=$result2->fetch_assoc()) {
                   
                   $userid = $row['student_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['student_id'] = $userid;
                 $session = $_SESSION['student_id'];
                 //echo $session;
                 //echo 'Login successful';
                 header('Location: student_homepage.php?successful');
                 
               } else {
                 
                 // if there is not data found set this statment 
                 echo '<p> <style> p {color:red;} </style> Username or Password invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
             
             
             
             
             
             // if the user hits tutor follow this route
           } else if ($type == 'Tutor') {
             echo 'Check 1';
             
             
             
             
             //check username is empty
             
             if(empty($_POST['user'])) {
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Username is empty <br/></p>';
               
               
               
               
             } else{
               
               
             }
             
             // check the password is empty
             $empty = true;
             if(empty($_POST['passw'])) { 
               // if this is true set it to the message below
               echo '<p> <style> p {color:red;} </style>  Password is empty <br/></p>';
             } else {
               // otherwise set this var used for verification
               $empty=false;
               
             }
             
             
             
             
             
             // If teh error checks or passed assert the sql statement
             if ($empty == false) {
               
               $auth2 = "SELECT * FROM tutor_details WHERE tutor_email = '$username' ";
               
               // execute the sql statement 
               $result2 = $conn->query($auth2);
               $numrows = $result2->num_rows;
               echo $numrows;
               //echo $auth;
               
               
               
               
               
               
               // if there is a error tell me 
               if(!$result2){
                 
                 echo $conn->error;
                 
               }
               
               
               // Get the password from a while loop 
               
               while($rowPassword = $result2->fetch_assoc()) {
                 $getPassword =$rowPassword['tutor_password'];
                 
               }
               
               
               // if the number of rows returned is over 0 and the password matches
               if ($numrows > 0 && $getPassword == $passw ) {
                 
                 // get the tutor id again 
                 $getId = "SELECT tutor_id FROM tutor_details WHERE tutor_email = '$username'";
                 $result3 = $conn->query($getId);
                 echo $getId;  
                 while ($row=$result3->fetch_assoc()) {
                   // get the tutor id
                   $userid = $row['tutor_id'];
                   
                 }
                 
                 // create the session
                 session_start();
                 $_SESSION['tutor_id'] = $userid;
                 $session = $_SESSION['tutor_id'];
                 echo $session;
                 echo 'Login successful';
                 
                 // send them to the tutor profile 
                 header("Location: ../tutor_level/tutor_home.php?loginsuccessful");
                 
               } else {
                 
                 // set the error message
                 echo '<p> <style> p {color:red;} </style> Username or Password Invalid <br/></p>';
               }
               
               
               
             } else {
               
               
             }
             
             
           }
         }
         
         
         
         ?>
      </div>
      </div>
   </body>
</html>