<?php
   // Start the session variables and security of the webpage
   include('../student_level/dbh.php');
   session_start();
   
   // lock and key
   if (!isset($_SESSION['student_id'])) {
       header('Location: ../student_level/login_page.php');
       
       
     } 
       
   
       
     // Get the customers profile picture
       $userid = $_SESSION['student_id'];
   
   
   
   //create the SQL statement for the class_list 
   
   
   
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <link rel="stylesheet" href="../tutor_level/css.calender/style.css"/>
   <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
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
      <div class="page-title">
         <h4> Calendar</h4>
      </div>
      <div class ="container">
         <div class ="container2">
          <div class ="container2">
            <div id="caleandar">
               <!-- Create the script tags to add the calendar -->
               <script type="text/javascript" src="js.calender/caleandar.js"></script>
               <script>
                  <?php
                     echo "var eventsarray = [";
                     /* echo "     {'Date': new Date(2021, 0, 11), 'Title': 'Doctor appointment at 3:25pm.','Link': '1'},
                     {'Date': new Date(2021, 0, 6), 'Title': 'New Onward movie comes out!', 'Link': 'example'},
                     {'Date': new Date(2021, 1, 27), 'Title': 'Sophies Birthday', 'Link': 'johns stuff'},
                     ";
                     */
                     
                     
                     $myClasses = "SELECT * FROM class_list INNER JOIN locations_table ON class_list.location_id =locations_table.location_id ";
                     $result = $conn->query($myClasses);
                     if (!$result) {
                       echo $conn->error;
                     }
                     
                     while($row=$result->fetch_assoc()) {
                       
                       $classDes = $row['class_details'];
                       $theDate = $row['class_date'];
                       $classid = $row['class_id'];
                       $location_name= $row['Location'];
                       
                       // edit the month to the correct month
                       $d = new DateTime($theDate);
                                 $d->modify('-1 month');
                                 $newD = $d->format('Y,m,d');
                     
                                
                     
                               
                                 // new date 
                                 $newDate = date('Y,M-1,D', strtotime($theDate));
                               
                                 //echo "Date: $theDate, Title: $classDes, link: view_classes.php?classid=$classid ";
                               
                                 echo " {'Date': new Date($newD), 'Title': '$classDes','Location': '$location_name'},";
                               }
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                         echo "  ];";
                     
                      ?>     
                        var settings = { NavShow: false,  EventTargetWholeDay: false, EventClick: function(Link) {console.log(Link);} };
                         
                        var calelement = document.getElementById('caleandar');
                        
                        caleandar(calelement, eventsarray, settings);
                      
                      
               </script>
               </div>
            </div>
         </div>
      </div>




      <!-- Check that the student has not already provided Feddback on this Topic -->
      <div  id ='register-div' class='container'>
        
         <!-- This is the Registration componenant that captures the student input when they want to register for a class -->
         <div class="container3">
            <h1> Register for Classes Here! <button id = "hide"> Hide </button> </h1>
            <h4>Select the Relevent Class</h4>
          
            <!-- FORM tag to return the data to the same file -->
            <form action="student_calender.php" class="update-resource" method ="POST">
               <select  placeholder= "Class Name" name="classname" required >
               <?php
                  // Get all the classes that exits so that these can be dispalyed in the select tag
                  
                  $classes = "SELECT * FROM class_list";
                  $result = $conn->query($classes);
                  
                  
                  echo "<option > Select a Class  </option>";
                  while ($row=$result->fetch_assoc()) {
                      $class_name= $row['class_details'];
                      $class_date= $row['class_date'];
                      $class_id = $row['class_id'];
                      
                      
                      echo "<option value='$class_id'> $class_name $class_date</option>";
                      
                  }
                  
                  
                  ?>
               </select>
               <!-- Input so that the user can enter the code that is associated with the class -->
               <div class="form-floating">
                  <textarea class="form-control" placeholder="Code" name ="code" id="floatingTextarea" required ></textarea>
               </div>
               <button name="submit" type="submit" style="background-color:yellowgreen;color:white;padding:5px;font-size:18px;border:none;padding:8px;"> Submit</button>
            </form>
            <!-- This is the component that will check that the student has entered the correct code to register for the class -->
            <?php 
               if(isset($_POST['submit'])) {
                 
                 $code = $_POST['code'];
                 $class_id = $_POST['classname'];
               
               
                 // There needs to be a check added to the component so that the user can not register twice 
               
                 $check = "SELECT * FROM class_registration WHERE student_id = '$userid' AND class_id = '$class_id'"; 
                 $executeCheck = $conn->query($check);
               // If the row already exists then dont let the user register twice. Duplicate Registration lead to an error in the system 
                 $check_rows = $executeCheck->num_rows; 
               
               
                 if ($check_rows <= 0) {
               
                   
                   
                   
                   // check that the code is correct for the class that it is being entered for
                   
                   $check = "SELECT * FROM class_list WHERE class_id = '$class_id ' AND class_code = '$code'";
                   $execute = $conn->query($check);
                   
                   
                   $numrows = $execute->num_rows; 
                   
                   
                   
                   if ($numrows == 1){
                     echo "<div class='container2'>";
                     echo '<p> <style> p {color:green;} </style>   You have successfully registered  <br/></p>';
                     
                     // Insert the data into the table so that the student can register for the class 
                     
                     $registration = "INSERT INTO class_registration (student_id, class_id) VALUES ('$userid', '$class_id') ";
                     $execute = $conn->query($registration);
                     
                     
                     
                   } else if ($numrows !=1) {
                     
                     echo '<p> <style> p {color:red;} </style> Code Invalid <br/></p>';
                     
                   }
                 } else {
                   echo '<p> <style> p {color:red;} </style>  You have already registered for this class <br/></p>';
                 }
               }
               
               ?> 
         </div>
      </div>
      <div class="classlist">
      <?php 
         $classes = "SELECT * FROM `class_registration` WHERE student_id = '$userid'";
         $getClasses = $conn->query($classes);
         
         $num_rows = $getClasses->num_rows;
         
         
         if ($num_rows == 0 ) {
           echo '<div class="container">';
           echo '<p> You have not registered for any classes currently </p>';
           echo '</div>';
         } else {
         
           echo '<div class="container">';
           echo '<div class="container2">';
           echo '<h2 style = "text-decoration: underline !important"> List of Classes that you have registered </h2>';
         
           while ($row=$getClasses->fetch_assoc()) {
         
             $class_id = $row['class_id'];
             // get the name of the content that has been dispalyed
             $getName = "SELECT * FROM class_list WHERE class_id ='$class_id'";
             $go = $conn->query($getName);
         
             while ($row=$go->fetch_assoc()) {
         
         
               echo '<div class="container">';
               echo '<div class="container2">';
               $class = $row['class_details']; 
               $class_date = $row['class_date'];
               
               echo "<img src='css.calender/tick.png' alt='Avatar'>";
               echo "<h4>$class: $class_date</h4>";
               echo '</div>';
               echo '</div>';
             }
         
             
           
           
         
           
         }
         echo '</div>';
         echo '</div>';
         
         
         }
         ?>
   </body>


   <!-- This is the script so that the feedback option will hide -->
<script>

$(document).ready(function(){
  $("#hide").click(function(){
    $("#register-div").toggle(1000);
  



});

});

$(document).ready(function(){
  $("#hide2").click(function(){
    $("#class-list-div").toggle(1000);
  



});

});

</script>
</html>
   </body>
</html>