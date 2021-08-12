<?php
   // Start the session variables and security of the webpage
   include('../student_level/dbh.php');
   session_start();
   
   // lock and key
   if (!isset($_SESSION['tutor_id'])) {
       header('Location: ../student_level/login_page.php');
       
       
   }
   
   
   
   
   
   
   // Get the customers profile picture
   $userid = $_SESSION['tutor_id'];
   
   // Get the contet id using the GET super
   
   $content_id = $_GET['contentid'];
   
   
   
   // if the user tries to access the page with no content 
   if ($content_id  == '' ) {
   
   
   }
   
   // Create a location Var that can be used do that the form tags can be used correctly
   $location = "tutor_view_module.php?contentid=$content_id";
   
   
   // //////////////////////////////////////////////////////////////////////////////////// CHECK THAT THE ENTRY TO THE PAGE IS LEGAL // ////////////////////////////////////////////////////////////////////////////////////
   
   // Check that the  entry is legal. This means that the user can not access teh page with out a valid content_id 
   
   $checkLegal = "SELECT * FROM module_content WHERE content_id ='$content_id'";
   $goLegal = $conn->query($checkLegal);
   
   $legalNum_rows = $goLegal->num_rows;
   
   if ($legalNum_rows  == 0  ) {
      
       header('Location: ../tutor_level/tutor_module.php');
       
   }
   
   
   
   
   
   // create the select statement that can get all the information about the content and then display it correctly
   
   
   $getWeek = "SELECT * FROM module_content WHERE content_id = '$content_id'";
   $result  = $conn->query($getWeek);
   while ($row = $result->fetch_assoc()) {
       $titleHead      = $row['module_content_title'];
       
       $getTheWeek  = $row['Week'];
       $content_id  = $row['content_id'];
       
     }
     ?>
<!-- Start of the HTML and Php Code needed for the functionality of this page -->
<!DOCTYPE html>
<html lang="en">
   <link rel="stylesheet" href="css.calender/style.css"/>
   <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <script src="https://kit.fontawesome.com/2d3dbf3534.js" crossorigin="anonymous"></script>
   <script defer src= "js.calendar/tutor_module.js"></script>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title> Module Content 2 </title>
   </head>
   <div  class="sidebar">
      <ul>
         <li class="active"> <a href="tutor_home.php "> <span class="material-icons"> home </span></a> </li>
         <li> <a href="tutor_module.php"> <span class="material-icons">  auto_stories</span></a> </li>
         <li> <a href="tutor_calender.php"> <span class="material-icons">  class </span>  </a> </li>
         <li> <a href="view_students.php"> <span class="material-icons">  people </span></a> </li>
         <li> <a href="tutor_account_settings.php"> <span class="material-icons">  settings </span>  </a> </li>
         <li> <a data-modal-target="#modal"> <span class="material-icons">   add  </span></a> </li>
         <li> <a href="tutor_disscussion_forum.php?contentid=<?php echo $content_id;?>" > <span class="material-icons">announcement </span></a> </li>
         <li><a href="tutor_log_out.php"> <span class="material-icons"> logout </span></a></li>
      </ul>
   </div>
   <!-- /////////////////////////////////////////////////////////////////////////////////// ADD MODULE CONTENT ///////////////////////////////////////////////////////////////////////////////////-->
   <div class="modal" id="modal">
      <div class="modal-header">
         <div class="title">Add Content Here </div>
         <button data-close-button class="close-button">&times;</button>
      </div>
      <div class="modal-body">
         <?php echo "<form action='tutor_view_module.php?contentid=$content_id' class='form' method = 'POST'>"?>
         <!-- Adding a dynamic select box so that the user can select the week that they want to add the content to -->
      </div>
      <div class="form-floating">
         <textarea class="form-control" placeholder="Title" name ="title" id="floatingTextarea" required ></textarea>
      </div>
      <div class="form-floating">
         <textarea class="form-control" placeholder="Add Content here" name ="content" id="floatingTextarea" required ></textarea>
      </div>
      <div class="container2">
         <div>
            <button data-submit name="submit" type="submit"> Create Content</button>
         </div>
      </div>
      </form>
      <?php
         if (isset($_POST['submit'])){
         // create the local vars from the inputs in the form tag
         $title = $_POST['title'];
         $comment = $_POST['content'];
         
         
         if (empty($comment)) {
         echo '<p> <style> {color:red;} </style>  You have not entered any content </p><br>';
         }
         
         
         if (empty($title)) {
         // echo statement + br 
         echo '<p> <style> {color:red;} </style>  No Name Entered! </p><br>';
         } else {
         
         
         
         
         
         
         
           // Create the content for thr module that the tutor can use to add content to the module
           $insert = "INSERT INTO module_content_information ( content_id, Title, Information) VALUES ('$content_id', '[$title]',   '[$comment]')";
           $insertContent = $conn->query($insert);
         
         
         
         
         
         
         
         }
         }
         ?>
   </div>
   </div>
   <div id="overlay"></div>
   <body>
      <!-- /////////////////////////////////////////////////////////////////////////////////// THIS IS THE VIEW MODULE CONTNET COMPONENT /////////////////////////////////////////////////////////////////////////////////// -->
      <!-- Add the page title  -->
      <div class="page-title">
         <h4><?php echo $titleHead?></h4>
      </div>
      <?php 
         $getContentInfo = "SELECT * FROM module_content_information WHERE content_id = '$content_id'";
         $result = $conn->query($getContentInfo);
         
         // Display a message if there is no content currently added 
         
         $num_rows = $result->num_rows;
         
         if ($num_rows == 0) {
         
           echo  "<div class='container view-content'>";
           echo  "<div class='container2''>";
           echo "<p> There is no content to show currently! </p>";
           
           
         
           echo "</div>";
           echo "</div>";
         
         } else {
         
         
         
         while($row=$result->fetch_assoc()) {
           $contentTitle = $row['Title'];
           $description = $row['Information'];
           $information_id = $row['information_id'];
         
         
           echo  "<div class='container-view-content''>";
           echo  "<div class='container2''>";
         
         
             
            echo "<h2>$contentTitle<h2>";
             
           
             echo "<p>$description<p>";
             echo "<button style='background-color:red;color:white;padding:5px;font-size:18px;border:none;padding:5px; margin: 5px;'> <a href='php_functionality/delete_content_information.php?contentid=$information_id'> Delete </a>   </button>";
            
           
         
           
         
           echo "</div>";
           echo "</div>";
           
          
         
           //echo "<p> <a href='student_profile.php?studentid=$student_id'> Student: $first_name  $second_name </a>    </p>";
         
         
         
         }
         }
         
         
         
         ?>
   </body>
</html>