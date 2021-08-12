<?php
   // Start the session variables and security of the webpage
   // Include the Database Connection
   include('../student_level/dbh.php');
   // Get the session to start 
   session_start();
   
   // add the Ob_start(); so that the page will not buffer 
   ob_start();
   
   
   
   // lock and key
   if (!isset($_SESSION['student_id'])) {
       header('Location: ../student_level/login_page.php');
       
       
   }
   
   
   
   
   
   // Get the customers profile picture
   $userid = $_SESSION['student_id'];
   
   // get the details of the content that the studnet is commenting on form the URL
   $content_id = $_GET['contentid'];
   
   // Check that the  entry is legal. This means that the user can not access teh page with out a valid content_id 
   
   $checkLegal = "SELECT * FROM module_content WHERE content_id ='$content_id'";
   $goLegal = $conn->query($checkLegal);
   
   $legalNum_rows = $goLegal->num_rows;
   
   if ($legalNum_rows  == 0  ) {
      
       header('Location: ../student_level/student_module.php');
       
   }
   
   
   // Use the method here 
   function getLike( $discussion_id)
   {
       //   The get like function that will be used in tutor_discussion_forum.php and student_discussion_forum.php
       // include the db connecyion in the file
       include('../student_level/dbh.php');
       
       $selectLikes = "SELECT * FROM likes_table WHERE discussion_id ='$discussion_id'";
       $execute     = $conn->query($selectLikes);
       
       // The number of likes will be determined by the the number of rows that exist in the likes table that will equal 
       
       $num_rows = $execute->num_rows;
       
       $likes = $num_rows;
       
       return $likes;
       
   }
   
   
   // get content details 
   
   $getContent = "SELECT * FROM module_content WHERE content_id = '$content_id'";
   $get = $conn->query($getContent);
   
   while ($row = $get->fetch_assoc()) {
       $title = $row['module_content_title'];
   
   }
   
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <link rel="stylesheet" href="../tutor_level/css.calender/style.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
   <script defer src= "../tutor_level/js.calendar/tutor_module.js"></script>
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
         <li> <a data-modal-target="#modal"> <span class="material-icons">   add  </span></a> </li>
         <li><a href="student_log_out.php"> <span class="material-icons"> logout </span></a></li>
      </ul>
   </div>
   <div class="page-title">
      <h4>Disscussion Forum:  </h4>
      <h5><?php echo $title;  ?></h5>
   </div>
   <div class="modal" id="modal">
      <div class="modal-header">
         <div class="title">Add Comment Here</div>
         <button data-close-button class="close-button">&times;</button>
      </div>
      <div class="modal-body">
         <?php
            echo "<form action='student_disscussion_forum.php?contentid=$content_id'  id = 'addcomment'  method ='POST'>";
            ?>
         <!-- We need to set the security functions so that the studnets cannot add content without a title -->
         <div class="form-floating">
            <textarea style = "200%" class="form-control" placeholder="Title"  name = "title" id="floatingTextarea"required></textarea>
         </div>
         <div class="form-floating">
            <textarea style = "200%" class="form-control" placeholder="Comment"  name = "comment" id="floatingTextarea" required></textarea>
         </div>
         <button name="submit" type="submit"> Send Comment</button>
         </form>
         <!-- Create the [hp code to add the comment to the database] -->
         <?php
            if (isset($_POST['submit'])) {
                
                
                $comment = $_POST['comment'];
                $title   = $_POST['title'];
                
                
                if (!empty($comment) && !empty($title)) {
            
            
                  // Create a Prepared Statement to prevent SQL injection
            
            
                  $prepared = $conn->prepare( "INSERT INTO content_discussion_forum (student_id, content_id, discussion_title, discussion_details) VALUES (?, ?, ?, ?)");
                  $prepared->bind_param("iiss", $userid, $content_id, $title, $comment );
                  $prepared->execute();
                    
                    // send the user back to the current page so that the comment is updated. 
                    $location   = "student_disscussion_forum.php?contentid=$content_id";
                    header("Location: $location");
                } else {
                    
                    echo "You must add a title aswell as a comment";
                    
                    
                    // Insert the comment into the database
                    
                    
                    
                }
                
                
                
                
                
                
            }
            
            ?>
         <!-- Adding a dynamic select box so that the user can select the week that they want to add the content to -->
      </div>
   </div>
   <div id="overlay"></div>
   <body style ="background:#ccc;"class = "profile-body">
      <div class="container">
         <div class="container2">
            <?php
               // Create a select statement that will decide which details to get for the forum
               $check = "SELECT * FROM content_discussion_forum WHERE content_id = '$content_id'";
               
               $request = $conn->query($check);
               //echo $check;
               
               
               if ($request->num_rows == 0) {
                   echo "No Messages yet";
                   
               } else {
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   // create the select statement that will get all the necessary information that is related to the disscussion forum such as the title and the comment and the owner
                   // This will need a join in the database to retrive all the necessary informtion that is needed for the student
                   
                   $getMessageStudent = "SELECT * FROM content_discussion_forum INNER JOIN
                       student_details
                           ON
                           content_discussion_forum.student_id = student_details.student_id
                           WHERE
                           content_discussion_forum.content_id = '$content_id'";
                   
                   $execute = $conn->query($getMessageStudent);
                   
                   
                   
                   
                   
                   while ($row2 = $execute->fetch_assoc()) {
                       // get the variables per message
                       $title         = $row2['discussion_title'];
                       $message       = $row2['discussion_details'];
                       $file          = $row2['imgpath'];
                       $time          = $row2['date'];
                       $fname         = $row2['student_first_name'];
                       $sname         = $row2['student_second_name'];
                       $discussion_id = $row2['discussion_id'];
                       $student_id    = $row2['student_id'];
                       
                       
                       
                       
                       
                       // get the likes for this post and check if they exist
                       $likes = getLike($discussion_id);
                       
                       
                       
                       $studentFile = "../tutor_level/$file";
                       echo "<div class='container2'>";
                       
                       echo "<img src='$studentFile' alt='Avatar'>";
                       echo "<h2 style ='text-decoration: underline !important;'>$title</h2>";
                       
                       echo "<h4>$message</h4>";
                       echo "<p> Student : $fname $sname</p>";
                       echo "<span class='time-right'>$time</span>";
               
               
                       // check that the Like exists to determine if they should like or unlike 
                       $checkLike = "SELECT * FROM likes_table WHERE discussion_id = '$discussion_id' AND  student_id = '$userid'";
                       $executeCheck = $conn->query($checkLike);
               
                       $exist = $executeCheck->num_rows;
               
                       if ($exist > 0 ) {
                           echo "<a href='php_functionality/discussion_forum_likes_unlike.php?type=post&id=$discussion_id&student=$userid'> Unlike $likes </a>";
                       } else {
                           
                           echo "<a href='php_functionality/student_discussion_forum_likes.php?type=post&id=$discussion_id&student=$userid'> Like $likes </a>";
                       }
                       
                       
                       //  Check if they have the right to delete the post     
                       if ($student_id == $userid) {
               
                           echo "<button id = 'module-content-delete' style=''> <a href='php_functionality/delete_DF_comment.php?discussionid=$discussion_id'> Delete </a>";
               
               
                       }
                       
                       
                       echo "</div>";
                       
                   }
                   
                   
                   
                   
                   
                   
                   
                   
                   // Tutor messages
                   
                   $getMessageTutor = "SELECT * FROM content_discussion_forum INNER JOIN
               tutor_details
               ON
               content_discussion_forum.tutor_id = tutor_details.tutor_id
               WHERE
               content_discussion_forum.content_id = '$content_id'";
                   
                   $execute = $conn->query($getMessageTutor);
                   
                   
                   
                   // Using this stnt so that the HMTL will display if the user has or hast liked the post in question 
                   
                   
                   
                   
                   
                   
                   
                   while ($row2 = $execute->fetch_assoc()) {
                       // get the variables per message
                       $title         = $row2['discussion_title'];
                       $message       = $row2['discussion_details'];
                       $file          = $row2['imgpath'];
                       $time          = $row2['date'];
                       $fname         = $row2['tutor_first_name'];
                       $sname         = $row2['tutor_second_name'];
                       $discussion_id = $row2['discussion_id'];
                       
                       $tutor_id = $row2['tutor_id'];
                       
                       
                       
                       
                       
                       $likes = getLike( $discussion_id);
                       
                       $studentFile = "../tutor_level/$file";
                       
                       
                       
                       
                       
                       echo "<div class='container2'>";
                       echo "<img src='$studentFile' alt='Avatar'>";
                       echo "<p style = 'style ='text-decoration: underline !important;''>$title</p>";
                       
                       echo "<p>$message</p>";
                       echo "<p> Tutor: $fname $sname</p>";
                       echo "<div class='container2'>";
                       echo "</div>";
                       echo "<span class='time-right'>$time</span>";
                       
               
                        // check that the Like exists to determine if they should like or unlike 
                        $checkLike = "SELECT * FROM likes_table WHERE discussion_id = '$discussion_id' AND  student_id = '$userid'";
                        $executeCheck = $conn->query($checkLike);
                
                        $exist = $executeCheck->num_rows;
                
                        if ($exist > 0 ) {
                            echo "<a style ='color:blue;' href='php_functionality/discussion_forum_likes_unlike.php?type=post&id=$discussion_id&student=$userid'> Unlike $likes </a>";
                        } else {
                            
                            echo "<a style ='color:blue;' href='php_functionality/student_discussion_forum_likes.php?type=post&id=$discussion_id&student=$userid'> Like $likes </a>";
                        }
               
                       
                       
                       
                       
                       echo "</div>";
                       
                   }
               }
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               ?>
         </div>
      </div>
      <!-- below is where students will be able to comment on the discussion forum -->
   </body>
</html>