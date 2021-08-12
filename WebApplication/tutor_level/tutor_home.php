<?php
   // Start the session variables and security of the webpage
   include('../student_level/dbh.php');
   session_start();
   
   
   // check for errors 
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   
   // lock and key
   if (!isset($_SESSION['tutor_id'])) {
       header('Location: ../student_level/login_page.php');
       
       
     } 
       
   
       
     // Get the customers profile picture
       $userid = $_SESSION['tutor_id'];
   
   
       // get the name of the student to present on the homepage of their account 
       $getName = "SELECT * FROM tutor_details WHERE tutor_id = '$userid'";
        $result2= $conn->query($getName);
        //echo $getName;
        //echo $getId;  
        while ($row=$result2->fetch_assoc()) {
          
          $tutor_First_Name= $row['tutor_first_name'];
          
        }
   
        
   
   
   
        
   
   
   
        
   
   
   
   
   
        ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- CSS File -->
      <link rel="stylesheet" href="css.calender/style.css"/>
      <!-- Google Icons -->
      <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- JS File -->
      <script defer src= "js.calendar/tutor_module.js"></script>
      <!-- Bootstrap -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title> Module Content </title>
   </head>
   <div  class="sidebar">
      <ul>
         <li class="active"> <a href="tutor_home.php "> <span class="material-icons"> home </span>  </a> </li>
         <li> <a href="tutor_module.php"> <span class="material-icons">  auto_stories </span></a> </li>
         <li> <a href="tutor_calender.php"> <span class="material-icons">  class </span>  </a> </li>
         <li> <a href="view_students.php"> <span class="material-icons">  people </span></a> </li>
         <li> <a href="tutor_account_settings.php"> <span class="material-icons">  settings </span>  </a> </li>
         <li> <a data-modal-target="#modal"> <span class="material-icons">    campaign  </span></a> </li>
         <li><a href="tutor_log_out.php"> <span class="material-icons"> logout </span></a></li>
      </ul>
      <body>
   </div>
   <div class="page-title">
   <h4>Home Page</h4>
   </div>
   <!-- This is the code that will appear when the tutor wants to make an annoucement to the students  -->
   <div class="modal" id="modal">
   <div class="modal-header">
   <div class="title"> Make Announcement Here! </div>
   <button data-close-button class="close-button">&times;</button>
   </div>
   <div class="modal-body">
   <form action="tutor_home.php" class="form" method = "POST">
   <!-- Adding a dynamic select box so that the user can select the week that they want to add the content to -->
   <div class="form-floating">
   <textarea style = "200%" class="form-control" placeholder="Title"  name = "title" id="floatingTextarea" required></textarea>
   </div>
   <div class="form-floating">
   <textarea class="form-control" placeholder="Leave a comment here" name ="comment" id="floatingTextarea" required ></textarea>
   </div>
   <button name="submitA" type="submit"> Send Announcement!</button>
   </form>
   <!-- Write the code that will pass the comments provided to the database  -->
   <?php 
      if (isset($_POST['submitA'])) {  
      
      
        $anouncementTitle = $_POST['title'];
        $anouncementComment = $_POST['comment']; 
      
        // insert into the databse 
        $insertAnouncement = "INSERT INTO Announcement_table (tutor_id, title, comment) VALUES ('$userid  ', '$anouncementTitle', '$anouncementComment')";
        $enterAnnouncement = $conn->query($insertAnouncement);
      
        $affected_rows = $enterAnnouncement-> num_rows; 
       echo $insertAnouncement;
      if ($affected_rows > 0 ) {
      
          echo '<p> <style> p {color:green;} </style> Anouncement Sent <br/></p>';
          echo "You have created $title in Week $week";
          $js == true; 
          // dispaly the conformation message. 
          echo '<script language="javascript">';
          echo 'alert("Content has been successfully created); location.href="tutor_home.php"';
          echo '</script>';
          header('Location: tutor_home.php');
        } else {
          // display the error message. 
          echo '<script language="javascript">';
          echo 'alert("There was a problem creating this content please try again!); location.href="tutor_home.php"';
          echo '</script>';
          header('Location: tutor_home.php');
        }
      
      }
      
      ?>
   </div>
   </div>
   <div id="overlay"></div>
   <!-- ------------------------------------------------------------------------------------------------------------------------- -->
   <!-- These are the methods that will be used to determine the attendence for the students of their classes -->
   <?php 
      //  Create the functions that will be needed to display the statistics for the tutor to view and make decision on 
      //  Lets start with class attendance 
      
      function fullAttendance() {
          include('../student_level/dbh.php');
          //  This will display to the user what the attendance for the entire semester 
      
          // Get the number of classes from MySQL Database 
          $getClasses = "SELECT * FROM class_list";
          $execute = $conn->query($getClasses);
      
          $numClasses = $execute->num_rows; 
      
      
          // Get the number of students
          $getStudents = "SELECT * FROM student_details";
          $execute2 = $conn->query($getStudents);
      
          $numStudents = $execute2->num_rows; 
      
      
          // The number of attend is $numStudents multiplied by $numClasses
          $possibleAttends = $numStudents * $numClasses;
      
      
          // get the total attends so far 
      
          $totalAttends = "SELECT * FROM class_registration";
      
          $getAttends = $conn->query($totalAttends);
      
          $allAttends = $getAttends->num_rows;
      
          // calulate the attendance 
      
          if ($allAttends < 0 ) {
            $generalAttendance==0; 
          } else {
      
            $generalAttendance =  round(($allAttends/$possibleAttends) * 100, 1); 
          }
      
      
          return $generalAttendance;
      
      
      }
      
      
      
      function classAttendance($num) {
      
          include('../student_level/dbh.php');
          //  This will display to the user what the attendance for the entire semester 
      
          
          // Get the number of students or know as the possible number of attends
          $getStudents = "SELECT * FROM student_details";
          $execute2 = $conn->query($getStudents);
      
          $numStudents = $execute2->num_rows; 
      
      
      
          // get the total attends so far 
      
          $totalAttends = "SELECT * FROM class_registration WHERE class_id = '$num'";
      
          $getAttends = $conn->query($totalAttends);
      
          $allAttends = $getAttends->num_rows;
      
      
      
          if ($allAttends < 0 ) {
            $totalAttendance==0; 
          } else {
      
            $totalAttendance = round (($allAttends/$numStudents) * 100, 1); 
          }
          // calulate the attendance 
      
      
          
      
          return $totalAttendance;
      
          
      
      
      }
      ?>
   <!-- --------------------------------------------------------------------------------------GET AVERAGE ATTENDENCE------------------------------------------------------------------------------- -->
   <!-- This is the General Attendence Component that is used to display the general attendence of the students that have been registered for the class -->
   <div class='container'>
   <div class='container2'>
   <h2 style = "text-decoration: underline !important;"> General Class Attendence</h2> 
   <?php 
      $showAttendance = fullAttendance();
      
      
      
      
      echo "<div class='progress-g'>";
      
      echo "<div class='progress-done-g' data-done='$showAttendance'> $showAttendance%";
      echo '</div>';
      
      echo "</div>";
      
      
      ?>
   <!-- General Attendance CSS   -->
 
   <style type ="text/css">
   .progress-g {
   background-color: #ccc;
   border-radius: 20px;
   height: 30px;
   width: 300px;
   }
   .progress-done-g {
   background: linear-gradient(to left, #F2709C, #FF9472) ;
   height:100%;
   width: <?php  echo $showAttendance?>%;
   border-radius: 20px;
   height: 100%; 
   display: flex; 
   align-items:center; 
   justify-content: center; 
   animation: progress-done 2s; 
   }
   </style>
   </div>
   </div>
   <!-- ---------------------------------------------------------------------------------------------GET INDIVIDUAL ATTENDENCE------------------------------------------------------------------------ -->
   <div class='container'>
   <div class='container2'>
   <h2 style = "text-decoration: underline !important;"> Check individual class Attendence</h2>
   <form action="tutor_home.php" class="update-resource" method ="POST">
   <select  placeholder= "Class Name" name="classname" >
   <?php 
      // put this code into a for loop to display all the conetent of the  classes on the screen 
      
       
      
      
      $classList = "SELECT * FROM class_list";
       $result = $conn->query($classList);
       echo "<option> Select a Class </option>";
       while($row=$result->fetch_assoc()) {
         $class_id = $row['class_id'];
         $title = $row['class_details'];
         $date = $row['class_date'];
      
      
      
         
         
         
         
         
        echo "<option name ='class_id' value='$class_id'>$title Date: $date </option>";
      
      }
      echo "</select>";
      
      
      
        echo "<button id ='get_start' name='submit' type='submit' style='background-color:red;color:white;padding:5px;font-size:18px;border:none;padding:8px; margin: 10px;'> Go </button>";
       
       echo "</form>"; 
       echo "</div>";
      
      
       
      if(isset($_POST['submit'])) {
      
      $class_id = $_POST['classname'];
      
      
      // get the name of the class
      $getNameOfClass = "SELECT * FROM class_list WHERE class_id ='$class_id'";
      $get = $conn->query($getNameOfClass);
      
      while ($row=$get->fetch_assoc()) {
        
        $name = $row['class_details'];
        
        
        $showIndividualAttendence = classAttendance($class_id);
        //Show the results of the registration in aprogress bar with css and html  -->
        
        
        
        echo "<div class='container2 '>";
        echo "<h3 style =' text-decoration: underline !important;'>  $name Content Completion  </h3>";
        echo "<div class='progress'>";
        if ($showAttendance!=0) {
          echo "<div class='progress-done' data-done='$showIndividualAttendence'  style = 'background: linear-gradient(to left, #F2709C, #FF9472) ;height:100%;width:<?php echo $showIndividualAttendence ?>%  ;border-radius: 20px;height: 100%; display: flex; align-items:center; justify-content: center; animation: progress-done 2s; '> $showIndividualAttendence%";
   } else {
   echo "<div class='progress-done' data-done='$showIndividualAttendence'  style = 'background: linear-gradient(to left, #F2709C, #FF9472) ;height:100%;width:0;border-radius: 20px;height: 100%; display: flex; align-items:center; justify-content: center; animation: progress-done 2s; '> $showIndividualAttendence%";
   }
   echo '</div>';
   echo "</div>";
   echo "</div>";
   }
   }
   ?>
   </div>
   <!-- CSS code to style the progress bar for the individual class that has been selected -->
   <style type ="text/css">
   .progress {
   background-color: #ccc;
   border-radius: 20px;
   height: 30px;
   width: 300px;
   }
   .progress-done {
   background: linear-gradient(to left, #F2709C, #FF9472) ;
   height:100%;
   width: <?php  echo $showIndividualAttendence?>%;
   border-radius: 20px;
   height: 100%; 
   display: flex; 
   align-items:center; 
   justify-content: center; 
   animation: progress-done 2s; 
   }
   </style>
   <!-- This is the code that will show the tutor the amount announcements that they have made recently to their students -->
   <!-- This is the container that will hold all the announcements for the platform -->
   <div class="container">
   <div class="container2">
   <h2 style ="text-decoration: underline !important;">Announcements Table</h2>
   <?php 
      // Select all the conetent from the relevent table 
      
      
      $announcements = "SELECT * FROM `Announcement_table` ORDER BY date DESC";
      $go = $conn->query($announcements);
      
      
      $num_rows = $go->num_rows;
      
      if ($num_rows <=0 ) {
        echo  "<div class='container2'>";
        echo  "<div class='container2'>";
        echo "<h2> Announcement Table </h2>";
        echo "<p> There is currenly no Announcements! </p>";
        
        
        
        echo "</div>";
        echo "</div>";
        
      } else {
        
        
        
        
        while ($row=$go->fetch_assoc()) {
          
          $theTitle = $row['title'];
          $theComment= $row['comment'];
          $temporyid = $row['tutor_id'];
          $announcement_id = $row['announcement_id'];
          $time = $row['date'];
          // get the tutor details to display them students. Grab the Tutor ID from the Announcement Table, pass it into the following selelct statement. A join cannnt be used in this context!
          
          $getTutorDetails = "SELECT * FROM tutor_details WHERE tutor_id ='$temporyid'";
          $get = $conn->query($getTutorDetails);
          
          
          
          
          
          
          
          
          
          echo "<div class='container '>";
          echo "<div class='container2 '>";
          
          
          
          
          while ($row2=$get->fetch_assoc()) {
            $fname = $row2['tutor_first_name'];
            $sname = $row2['tutor_second_name'];
            $file = $row2['imgpath'];
            
            echo "<img src='$file' alt='Avatar'>";
            echo "<p> Tutor : $fname $sname</p>";
          }
          echo "<h2 style = 
          style ='text-decoration: underline !important;'>$theTitle</h2>";
          
          echo "<h3>$theComment</h3>";
          echo "<span class='time-right'>$time</span>";
          echo "<button id = 'module-content-delete' style=''> <a href='php_functionality/delete_announcement.php?announcementid=$announcement_id'> Delete </a>   </button>";
          
          
          
          
          
          
          
          echo "</div>";
          echo "</div>";
          
        }
      }
      ?>
   <!-- This is the HTML for the Delete Announcement Button which will prompt the user to confrim that they actually wanto to delete the post  -->
   </div> 
   </div>
   </body>
</html>