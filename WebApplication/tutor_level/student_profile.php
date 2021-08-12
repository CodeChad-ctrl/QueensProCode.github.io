<?php

// Start the session variables and security of the webpage
include('../student_level/dbh.php');
session_start();

// lock and key
if (!isset($_SESSION['tutor_id'])) {
    header('Location: ../student_level/login_page.php');
    
    
  } 
    

    
  // Get the tutor_id
    $userid = $_SESSION['tutor_id'];

    $student_id=$_GET['studentid'];



    // //////////////////////////////////////////////////////////////////////////////////// CHECK THAT THE ENTRY TO THE PAGE IS LEGAL // ////////////////////////////////////////////////////////////////////////////////////

// Check that the  entry is legal. This means that the user can not access teh page with out a valid content_id 

$checkLegal = "SELECT * FROM student_details WHERE student_id ='$student_id'";
$goLegal = $conn->query($checkLegal);

$legalNum_rows = $goLegal->num_rows;

if ($legalNum_rows  == 0  ) {
   
    header('Location: ../tutor_level/view_students.php');
    
}





    // get the name of the student to present on the homepage of their account 
    $getName = "SELECT * FROM tutor_details WHERE tutor_id = '$userid'";
     $result2= $conn->query($getName);
     //echo $getName;
     //echo $getId;  
     while ($row=$result2->fetch_assoc()) {
       
       $tutor_First_Name= $row['tutor_first_name'];
       
     }

     



     // create the select statement so that the tutor can add students to the system 



     





     ?>


<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="css.calender/style.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Module Content </title>
</head>

<div  class="sidebar">
     
   <ul>
   
   
     
   <li class="active"> <a href="tutor_home.php "> <span class="material-icons"> home </span></a> </li>
   <li> <a href="tutor_module.php"> <span class="material-icons">  auto_stories</span></a> </li>
   <li> <a href="tutor_calender.php"> <span class="material-icons">  class </span>  </a> </li>
  <li> <a href="view_students.php"> <span class="material-icons">  people </span></a> </li>
   <li> <a href="tutor_account_settings.php"> <span class="material-icons">  settings </span>  </a> </li>
   <li><a href="tutor_log_out.php"> <span class="material-icons"> logout </span></a></li>
   

   
   
   

   </ul>
</div>
<div>
<ul class = "headers">

    

</ul>
</div>
<body>
<div class="container2">
<div class="container2">

<div class="page-title">
<h1>View Student Profile</h1>

</div>



<!-- Add the Google Fonts for the CSS style design  -->

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
<!-- Bootstrap CSS -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
<!-- Font Awesome CSS -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>


<!-- Get the PHP code that will get all the relevent details for the student  -->
<?php 

$student_details = "SELECT * FROM student_details WHERE student_id = '$student_id'";

$getStudent_details = $conn->query($student_details);

while($row=$getStudent_details->fetch_assoc()) {

    $fname = $row['student_first_name'];
    $sname = $row['student_second_name'];
    $profile_pic = $row['imgpath'];


}


// Create a function that will get the average attendence of the student 
/////////////////////////////////////////////////// GET AVERAGE ATTENDENCE  ////////////////////////////////////////////////////

        function studnetAttendence($student_id) {


            include('../student_level/dbh.php');
            //  This will display to the user what the attendance for the entire semester 

            
        // get possible attends and total attends and then do the simple calculation 
        // possible attends = 

        $getPossibleAttends = "SELECT * FROM class_list";
        $execute = $conn->query($getPossibleAttends);

        $possibleAttends = $execute->num_rows;



            //  Get the total attends 

            $totalAttends = "SELECT * FROM class_registration WHERE student_id = '$student_id'";
            $execute2 = $conn->query($totalAttends);

            $totalAttends = $execute2->num_rows;



            $totalAttendance = round (($totalAttends/$possibleAttends) * 100, 1); 

            

            return $totalAttendance;

}

// call the functiona and set the variable 

$attendancePercentage = studnetAttendence($student_id);
//////////////////////////////////////////////////// GET AVERAGE FEEDBACK  ////////////////////////////////////////////////////

function getAverageFeedback($student_id) {
  // include the db connection.
  include('../student_level/dbh.php');

  // I need to create a equation to get the average Feedback for the student feedback which I will use to calculte the data needed to display to the tutor 
  // To get this I will start by selecting the amount of rows that exist within the content feedback table. The studnet can only get average feedback for content that they have completed.

  
  //Query and execution 
  $getActualFeedback = "SELECT * FROM content_feedback_table WHERE student_id = '$student_id'";
  $executeActualFeedback= $conn->query($getActualFeedback);

  // Get the number of rows that exist and then multiple that 5 
  $existingFeedback = $executeActualFeedback->num_rows; 
  // Place that in a variable called possible feedback as this is the total possible feedback score that the student could provide
  $possibleFeeback = ($existingFeedback * 5);


  // insert checks because the student may not have inserted anything yet which could be an issue.
  // If 0 rows are returned then the student will automatically be given a 0 and the function will return a 0 

  if ($existingFeedback == 0 ) {
     $feebackData = 0; 
  } else {
    // if the function does not retun a 0 then do this 
    $rating_number = 0; 
    while ($row=$executeActualFeedback->fetch_assoc()) {
      // loop through all the rating scores that the student has provided
      // then add them to the $rating_number var in each increment of the loop
      // cast the variable so that it is returned as an int
    $rating_number+= (int)$row['rating_number'];
    }
      
    
    // do the calulation so that a average figure is returned in an integer for 
    $feebackData = ($rating_number/$possibleFeeback * 100);

    echo "<p>$rating_number</p>";
    echo "<p>$possibleFeeback</p>";

    

      
return $feebackData;

  
}







}
      
  
       
      
      
      


 







  


//////////////////////////////////////////////////// GET CONTENT COMPLENTION ////////////////////////////////////////////////////

function getContentCompletion($student_id) {

   // include the db connection.
   include('../student_level/dbh.php');

  // Once again this is the standard formula that will be taking the possible content completion and the actual content completion to formulate information that the tutor can use to assess the progress of their pupil 
  // get the possible contentCompletion 

 $getPossibleContent = "SELECT * FROM module_content";
 $execute = $conn->query($getPossibleContent);

//  Use the num_rows functionality to get the possible amount of content that could exist
 $num_rows = $execute->num_rows; 
 $possibleContentCompletion = $num_rows; 

// --------------------------------------------------------------------------------------------------------------------------
// Now get the total amount of completions that the user has completed which will be taken from the content_feedback_table. Logically the pupil will not have provided feed back for a content that they have not completed 

$getTotalContent = "SELECT * FROM content_feedback_table WHERE student_id = '$student_id' AND content_feedback_table.rating_number IS NOT NULL";
$executeTotalContent = $conn->query($getTotalContent);

$num_rows = $executeTotalContent->num_rows; 

$totalContentCompletion = $num_rows;

// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//  Then do the calculation 

$completionPercentage = 0;
if($totalContentCompletion<=0) {

  $completionPercentage=0;

} elseif ($totalContentCompletion > 0){

  $completionPercentage =  round(($totalContentCompletion/$possibleContentCompletion* 100), 1);
}


return $completionPercentage;

}


/* Section used to call the fuctions needed and then to insert them into the database*/

// call the function that will get the average for the feeback 

$feedbackPercentage = getAverageFeedback($student_id);

// call this so that tutor can get the content complation_rate 

$completionPercentage = getContentCompletion($student_id);



?>

<!-- ///////////////////////////////////////////////////// GENERAL CONTENT FEEDBACK  //////////////////////////////////////////////////// -->

<div class="student-profile py-4">
  <div class="container">
  <div class="container2">
    <div class="container2">    
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" <?php echo "src='$profile_pic'"?> alt='student dp'>
            <?php echo "<h3>$fname $sname </h3>" ?>

          </div>
          
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i> Performance</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th width="30%">General Attendance</th>
                <td width="2%">:</td>
                <td>

               <div class='progress-g'>

                
                <div class='progress-done' data-done='$attendancePercentage'  style = 'background: linear-gradient(to left, #F2709C, #FF9472) ;height:100%;width:<?php echo $attendancePercentage ?>%  ;border-radius: 20px;height: 100%; display: flex; align-items:center; justify-content: center; animation: progress-done 2s; '>
                <?php echo "$attendancePercentage%"?>

                </div>

                </div>
                
                </td>
              </tr>
              <tr>
                <th width="30%"> General Feedback 	</th>
                <td width="2%">:</td>

                <td>

                <!-- Using a detailed if else statement based on the average feed back to replay to the tutor how the student is getting on with their work -->

                <?php 

               
               

                



                    if ($feedbackPercentage==0) {
                    echo '<p> <style> color:black; </style> No Feedback Given </p>';
                  } elseif ($feedbackPercentage <=20) {
                    echo '<p> <style> color:red; </style> Poor  </p>';
                  } elseif ($feedbackPercentage > 20 && $feedbackPercentage <=40) {
                    echo '<p> <style> color:red; </style> Unsatisfactory  </p>';
                  } elseif ($feedbackPercentage > 40 && $feedbackPercentage <=60) {  
                    echo '<p> <style> color:gold;</style> Satisfactory </p>';
                  } elseif ($feedbackPercentage > 60 && $feedbackPercentage <=80) {  
                    echo '<p> <style> color:green; </style> Good </p>';
                  } elseif ($feedbackPercentage > 80 &&$feedbackPercentage  <=100) {  
                    echo '<p> <style> color: green; </style> Excellent </p>';
                  }  elseif ($feedbackPercentage > 100) {  
                    echo '<p> <style> color: green; </style> Excellent </p>';
                  }
              


                

               ?>
                  
                
                </td>
                
              </tr>
             
              <!-- ///////////////////////////////////////////////////// CONTENT FEEDBACK  //////////////////////////////////////////////////// -->
              <tr>
                <th width="30%"> Content Feedback	</th>
                <td width="2%">:</td>

                <td>

                <!-- Using option tags the titor will select a class that he/she wants to see the feedback for the individual student -->

                





    


                    <?php echo "<form action='student_profile.php?studentid=$student_id' class='update-resource' method ='POST'>" ?>
                    <select  placeholder= "Content Name" name="contentname" >
                    <?php 
                                
                    // put this code into a for loop to display all the module conetnt on the screen that the tutor can select from

                    $classList = "SELECT * FROM module_content";
                    $result = $conn->query($classList);
                    echo "<option> Select Content </option>";
                    while($row=$result->fetch_assoc()) {
                      $content_id = $row['content_id'];
                      $title = $row['module_content_title'];
                      $week = $row['Week'];
                     

                      echo "<option name ='content_id' value='$content_id'> Week $week: $title  </option>";

                    }
                    echo "</select>";



                      echo "<button id ='get_start' name='submit' type='submit' style='background-color:red;color:white;padding:5px;font-size:10px;border:none;padding:8px; margin: 10px;'> Get Feedback </button>";
                    
                    echo "</form>"; 


                    if (isset($_POST['submit'])) {
                      // Select the student feedback concern this content in the module 
                        $content_id = $_POST['contentname'];

                      if ($content_id == 0) {
                        echo '<p> <style> color:black; </style> Nothing Selected </p>';

                      } else {
                        
                        // check if the rating that is being asked for actually exists 
                        $checkExistance = "SELECT * FROM content_feedback_table WHERE student_id = '$student_id' AND content_id = '$content_id'";
                        $go = $conn->query($checkExistance);
  
                        $number_rows = $go->num_rows;

                      if ($number_rows > 0) {

                        $getContentFeedBackNull = "SELECT * FROM content_feedback_table INNER JOIN module_content ON content_feedback_table.content_id = module_content.content_id WHERE student_id = '$student_id' AND content_feedback_table.content_id = '$content_id' AND content_feedback_table.rating_number IS NULL";
                        $executeNull = $conn->query($getContentFeedBackNull);
                        $rating = null;
                        $num_rowsContentNull = $executeNull->num_rows;

                        if ($num_rowsContentNull > 0 ) {



                          while ($row=$executeNull->fetch_assoc()) {
                            $name = $row['module_content_title'];
                            
                            echo "<h5> $name  </h5>";
                            echo '<p> <style> color:black;</style> No Feedback Given </p>';



                          }

                        } else {

                        

                       
                      
                      
                      $getContentFeedBack = "SELECT * FROM content_feedback_table INNER JOIN module_content ON content_feedback_table.content_id = module_content.content_id WHERE student_id = '$student_id' AND content_feedback_table.content_id = '$content_id' AND content_feedback_table.rating_number IS NOT NULL";
                      $execute = $conn->query($getContentFeedBack);
                      $rating = null;
                      $num_rowsContent = $execute->num_rows;



                        while ($row=$execute->fetch_assoc()) {
                        $name = $row['module_content_title'];
                        $rating = (int) $row['rating_number'];

                        
                        
                        
                        
                       
                          
                        




                        
                        // Construct the If else statement that will display to the tutor what the stading is for the student in relation to this module 
                        echo "<h5> $name  </h5>";
                        if ($rating == 0) {
                          echo '<p> <style> color:black;</style> No Feedback Given </p>';
                        } elseif ($rating == 1 ) {
                          echo '<p> <style> color:red; </style> Poor  </p>';
                        } elseif ($rating ==  2 ) {
                          echo '<p> <style> color:red; </style> Unsatisfactory  </p>';
                        } elseif ($rating  == 3) {  
                          echo '<p> <style> color:gold; </style> Satisfactory </p>';
                        } elseif ($rating == 4) {  
                          echo '<p> <style> color:green; </style> Good </p>';
                        } elseif ($rating == 5) {  
                          echo '<p> <style>  color: green; </style> Excellent </p>';
                        }  elseif ($feedbackPercentage > 5 ) {  
                          echo '<p> <style> color: green; </style> Excellent </p>';
                        }
                      
                        
                      }
                    }

                    } else {


                      $getContentFeedBack = "SELECT * FROM content_feedback_table INNER JOIN module_content ON content_feedback_table.content_id = module_content.content_id WHERE student_id = '$student_id' AND content_feedback_table.content_id = '$content_id' AND content_feedback_table.rating_number IS NOT NULL";
                      $execute = $conn->query($getContentFeedBack);
                      $rating = null;

                      while ($row=$execute->fetch_assoc()) {
                        $rating = (int) $row['rating_number'];
                        $name = $row['module_content_title'];

                        echo "<h5> $name:  </h5>";
                      }
                      echo "<h5> The Student has not accessed this content yet!</h5>";
                      
                    }
              

                    }
                  }

                    ?>

              </tr>
            <!-- //////////////////////////////////////////////////// CONTENT COMPLETION  //////////////////////////////////////////////////// -->

              <tr>
                <th width="30%">Content Completion</th>
                <td width="2%">:</td>
                <td>

               <div class='progress-g'>

               
                
                <div class='progress-done' data-done='$completionPercentage'  style = 'background: linear-gradient(to left, #F2709C, #FF9472) ;height:100%;width:<?php echo $completionPercentage?>%  ;border-radius: 20px;height: 100%; display: flex; align-items:center; justify-content: center; animation: progress-done 2s; '>
                <?php echo "$completionPercentage%"?>

                </div>

                </div>
                
                </td>
              </tr>

              
             
              
             
            </table>
          </div>
        </div>
          <div style="height: 26px"></div>
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Other Information</h3>
          </div>
          <div class="card-body pt-0">
              <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div> 
</div>  
</div>  
</div>






</body>
</html>

                    
                    
                    



                      
                      
                      
                      
                      




              
                  
                
         
                


