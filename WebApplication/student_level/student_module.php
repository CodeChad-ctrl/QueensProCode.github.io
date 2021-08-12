<?php
   // Start the session variables and security of the webpage
   include ('../student_level/dbh.php');
   session_start();
   
   // lock and key
   if (!isset($_SESSION['student_id']))
   {
       header('Location: ../student_level/login_page.php');
   
       echo $userid;
   
   }
   
   // Get the customers profile picture
   $userid = $_SESSION['student_id'];
   
   // create the select statement so that the tutor can add students to the system
   
   
   
   ?>
<!-- Start of the HTML and Php Code needed for the functionality of this page -->
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
   </div>
   <div class="page-title">
      <h1>Module Page</h1>
   </div>
   <div class="container">
      <?php
         $allContent = "SELECT * FROM module_content";
         $go = $conn->query($allContent);
         $num_rows = $go->num_rows;
         
         $contentNumber = $num_rows;
         
         // get the amount of rows form the feedback table to tell the studnet what they have completed
         $completed = "SELECT * FROM content_feedback_table WHERE student_id ='$userid' AND content_feedback_table.rating_number IS NOT NULL";
         $execute = $conn->query($completed);
         $num_rows2 = $execute->num_rows;
         $completion = $num_rows2;
         
         ?>
      <div class="container2">
         <div class="c_box">
            <h4> Content Completion </h4>
         </div>
         <div class="c_box">
            <p>  You have Completed <?php print_r($completion); ?> / <?php print_r($contentNumber); ?> of content available  </p>
         </div>
      </div>
   </div>
   <!-- This will tell the user how much content they have completed and how much is left -->
   <!-- This is the view Content Component -->
   <?php
      // This will display all the code that will display all the content of the module in relation to weeks
      
      
      //get all the data associated with the week
      $getWeek = "SELECT * from Weeks_table ORDER BY Week ASC";
      $query = $conn->query($getWeek);
      
      
      
      
      while ($row = $query->fetch_assoc())
      {
      
          $theTitle = $row['Title'];
          $num = $row['Week'];
      
          // If there is no content do not show the student that the week exists
      
          $checkContent = "SELECT * FROM module_content WHERE Week = '$num'";
          $get = $conn->query($checkContent);
      
          $number_rows = $get->num_rows; 
      
          if ($number_rows > 0 ) {
      
          
      
          echo "<div class='container'>";
          echo "<div class='container3'>";
          echo "<h1 id = 'content-title'style ='text-decoration: underline !important; '> Week $num: $theTitle  </h1>";
      
          $module = "SELECT * from module_content WHERE Week = '$num'";
          $result = $conn->query($module);
      
          while ($row = $result->fetch_assoc())
          {
              $title = $row['module_content_title'];
              $getTheWeek = $row['Week'];
              $content_id = $row['content_id'];
      
              // This will check if the student has completed the lab work or not yet
              $completed = "SELECT * FROM content_feedback_table WHERE student_id = '$userid' AND  content_id = '$content_id' AND rating_number IS NOT NULL";
              $execute = $conn->query($completed);
      
              $num_rows = $execute->num_rows;
      
              echo "<div class='container'>";
              echo "<div class='container2'>";
              echo "<p> <a href='student_view_module.php?contentid=$content_id' style ='color:black;text-decoration: underline !important;  '> Title: $title </a>   </p>";
      
              if ($num_rows > 0)
              {
                  echo "<p style ='color:green;'> Completed </p>";
              }
      
              echo "</div>";
              echo "</div>";
      
          }
          echo "</div>";
          echo "</div>";
      
      } else {
          // do nothing   
      }
      }
      
      ?>
   <body>
   </body>
</html>