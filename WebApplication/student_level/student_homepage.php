<?php
   // This is the student homepage, that studnets will be returned to once they have successfully signed into the application so they can see any updates.
   
   // Start the session variables and security of the webpage
   include('dbh.php');
   session_start();
   
   // lock and key
   if (!isset($_SESSION['student_id'])) {
       header('Location: login_page.php');
       
       
     } 
       
   
       
     // Get the customers profile picture
       $userid = $_SESSION['student_id'];
   
   
       // get the name of the student to present on the homepage of their account 
       $getName = "SELECT * FROM student_details WHERE student_id = '$userid'";
        $result2= $conn->query($getName);
        //echo $getName;
        //echo $getId;  
        while ($row=$result2->fetch_assoc()) {
          
          $student_First_Name= $row['student_first_name'];
          
        }
   
       
   
   
   
       
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <link rel="stylesheet" href="../tutor_level/css.calender/style.css"/>
   <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title> Module Content </title>
   </head>
   <div  class="sidebar">
      <ul>
         <li class="active"> <a href="student_homepage.php "> <span class="material-icons"> home </span></a> </li>
         <li> <a href="student_module.php"> <span class="material-icons">  auto_stories</span></a> </li>
         <li> <a href="student_calender.php"> <span class="material-icons">  class </span>  </a> </li>
         <li> <a href="account_settings.php"> <span class="material-icons">  settings </span>  </a> </li>
         <li><a href="student_log_out.php"> <span class="material-icons"> logout </span></a></li>
      </ul>
   </div>
   <body>
      </div>
      <div class="page-title">
         <h4>Home Page</h4>
      </div>
      <?php 
         // Select all the conetent from the relevent table 
         
         // If there is no announcements then return a message saying that there is no announcements currently
         $announcements = "SELECT * FROM `Announcement_table` ORDER BY date DESC";
         $go = $conn->query($announcements);
         
         
         $num_rows = $go->num_rows;
         
         if ($num_rows <=0 ) {
         
           echo  "<div class='container'>";
           echo  "<div class='container2'>";
           echo "<h2> Announcement Table </h2>";
           echo "<h4> There is currenly no Announcements! </h4>";
          
           
         
           echo "</div>";
           echo "</div>";
         
         } else {
           
         
         while ($row=$go->fetch_assoc()) {
         
           $theTitle = $row['title'];
           $theComment= $row['comment'];
           $temporyid = $row['tutor_id'];
           $time = $row['date'];
           // get the tutor details to display them students. Grab the Tutor ID from the Announcement Table, pass it into the following selelct statement. A join cannnt be used in this context!
         
           $getTutorDetails = "SELECT * FROM tutor_details WHERE tutor_id ='$temporyid'";
           $get = $conn->query($getTutorDetails);
         
         
           
         
         
           
         
           echo "<div class='container'>";
           
           echo "<div class='container2'>";
           echo "<h2> Announcement  </h2>";
           echo "<div class='container2'>";
         
                 
           
           while ($row2=$get->fetch_assoc()) {
             $fname = $row2['tutor_first_name'];
             $sname = $row2['tutor_second_name'];
             $file = $row2['imgpath'];
         
             // create a variable using the correct directory 
             $studentFile = "../tutor_level/$file";
         
             
             
                   echo "<img src='$studentFile' alt='Avatar'>";
                   echo "<p> Tutor : $fname $sname</p>";
                 }
                 echo "<p>$theTitle</p>";
                 
                 echo "<p>$theComment</p>";
                 echo "<span class='time-right'>$time</span>";
                 
                 
                
                 
                 
                 echo "</div>";
                 echo "</div>";
                 echo "</div>";
         
         }
         }
         ?>
   </body>
</html>