<?php

// Start the session variables and security of the webpage
include('../student_level/dbh.php');
session_start();

// lock and key
if (!isset($_SESSION['student_id'])) {
    header('Location: ../student_level/login_page.php');
    
    
  } 
    

    
  // Get the customers profile 
    $userid = $_SESSION['student_id'];

    // Get the contet id using the GET super and set this as a cookie 
    

    $content_id = $_GET['contentid'];


// set the location for the the use of form tags 

$location = "student_view_module.php?contentid=$content_id";

// Check that the  entry is legal. This means that the user can not access teh page with out a valid content_id 

$checkLegal = "SELECT * FROM module_content WHERE content_id ='$content_id'";
$goLegal = $conn->query($checkLegal);

$legalNum_rows = $goLegal->num_rows;

if ($legalNum_rows  == 0  ) {
   
    header('Location: ../student_level/student_module.php');
    
}

?>
    

 


<!-- Start of the HTML and Php Code needed for the functionality of this page -->







<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../tutor_level/css.calender/style.css"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script defer src= "js.calender/student_module.js"></script>
<script src="https://kit.fontawesome.com/2d3dbf3534.js" crossorigin="anonymous"></script>
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
   <li> <a href="student_disscussion_forum.php?contentid=<?php echo $content_id;?>" > <span class="material-icons">  campaign </span></a> </li>
   
   <li><a href="student_log_out.php"> <span class="material-icons"> logout </span></a></li>
   
   

   
   
   

   </ul>
</div>
<body>


<!-- Add the page title  -->
>







  <!-- PHP Section to display the module content on the page -->
  <?php 

  // put this code into a for loop to display all the conetent of the module on the screen 


  
  
 
  $getWeek = "SELECT * FROM module_content WHERE content_id = '$content_id'";
  $result = $conn->query($getWeek);

 
    
 
 


    
 
    
 
 
 
 
    
 
    
    
    
    while($row=$result->fetch_assoc()) {
        $title = $row['module_content_title'];
        
        $getTheWeek = $row['Week'];
        $content_id = $row['content_id'];

        

        
        
        





           

         
       
        
       
        
        
        echo "<div class='page-title'>";
        echo "<h3>$title</h3>";
      
        echo "</div>";
        
        
        
        
        
        
    }
    
    
    
    
  
    
    ?>





<!-- Use  the JavaScript to send the rating to the database -->




<div id = "feedback-div" class="container">
<div class='container2'>

<div class="give-feedback-title">
<h2> Guide </h2>
<button id = "hide"> Hide Feedback Option  </button>
</div>
<h3> 5 Stars = Excellent </h3>
<h3> 4 Stars = Good </h3>
<h3> 3 Stars = Satisfactory </h3>
<h3> 2 Stars = Unsatisfactory </h3>
<h3> 1 Star = Poor </h3>

</div>

</div>

<div id = "feedback-div-stars" class="container">
<div class='container2'>
<div class="give-feedback-title">
<h2>Give Feedback about the content</h2>
<button id = "hide2"> Hide Feedback Option  </button>
</div>


<div class="container2">
<div  style = "background: #ccc padding: 150px;">
  <i class = "fa fa-star" data-index = "0"></i>
  <i class = "fa fa-star" data-index = "1"></i>
  <i class = "fa fa-star" data-index = "2"></i>
  <i class = "fa fa-star" data-index = "3"></i>
  <i class = "fa fa-star" data-index = "4"></i>
  
</div>

</div>

<div>



<?php 







// Check if the user has already provided feedback about this content and tell them if so 

$checkStars = "SELECT * FROM content_feedback_table WHERE student_id = '$userid' AND content_id ='$content_id' AND rating_number IS NOT NULL";
$executeStars = $conn->query($checkStars);

$exist = $executeStars->num_rows; 

if ($exist > 0 ) {

    while ($row=$executeStars->fetch_assoc()) {
        $feedback = $row['rating_number'];

    }

   
  echo "<h3> You have already provided feedback for this content Rating: $feedback</h3>";

//   This will return a message based on the feedback that was given
  if ($feedback==1) {
    echo '<h3> <style> color:black; </style>  You struggled with this content</h3>';
  } elseif ($feedback==2) {
    echo '<h3> <style> color:red; </style>  You said you felt unsatisfied with the content </h3>';
  } elseif ($feedback==3) {
    echo '<h3> <style> color:red; </style>  You said that you where satisfied with this content </h3>';
  } elseif ($feedback==4) {  
    echo '<h3> <style> color:gold;</style>  You said you performed well with this content</h3>';
  } elseif ($feedback==5) {  
    echo '<h3> <style> color:green; </style>  You said you preformed extremly well with this content </h3 >';
  } 

  

  

  

} else {
 
  echo "<h3> You have not submitted any feedback yet!</h3>";
  
}


  


?>



</div>
</div>
</div>
</div>
















<!--  This is the JavaScript that will be used for the functionality of the star system that is set up on the User Interface -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>


var ratedIndex = -1, uID = <?php echo $content_id ?>;

        $(document).ready(function () {
            resetStarColors();

            if (localStorage.getItem('ratedIndex') != null) {
                setStars(parseInt(localStorage.getItem('ratedIndex')));
               
            }

            $('.fa-star').on('click', function () {
               ratedIndex = parseInt($(this).data('index'));
               localStorage.setItem('ratedIndex', ratedIndex);
               localStorage.setItem('uID', uID);

               saveToTheDB();
            });

            $('.fa-star').mouseover(function () {
                resetStarColors();
                var currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            $('.fa-star').mouseleave(function () {
                resetStarColors();

                if (ratedIndex != -1)
                    setStars(ratedIndex);
            });
        });

        function saveToTheDB() {
            $.ajax({
               url: "student_view_module.php?contentid=$content_id",
               method: "POST",
               dataType: 'json',
               data: {
                   save: 1,
                   uID: uID,
                   ratedIndex: ratedIndex
               }, success: function (r) {
                    uID = r.id;
                    localStorage.setItem('uID', uID);
               }
            });
        }

        function setStars(max) {
            for (var i=0; i <= max; i++)
                $('.fa-star:eq('+i+')').css('color', 'gold');
        }

        function resetStarColors() {
            $('.fa-star').css('color', 'grey');
        }



</script>

<?php

// A more complex level of coding is needed to make this page function the way I want it too. I need to insert a default rating row into the MySQL database for each content for each student.
// I will insert this first and then use an update function after that is completed. 
// start the relevent check process that will only let the user insert a rating once per content and will update their rating when they want to 

$checkSQL = "SELECT * FROM content_feedback_table WHERE student_id ='$userid' AND content_id = '$content_id'";

$execute = $conn->query($checkSQL);

$num_rows = $execute->num_rows;





// use an if statement for the checks ]

if ($num_rows == 0) {
    $insert= "INSERT INTO content_feedback_table (content_id, student_id) VALUES ('$content_id', '$userid')";
    $execute = $conn->query($insert);

} else {
    // Do nothing as a feedback table for this student and content already exits

}


if (isset($_POST['save'])) {

// Set the relevent variables

$ratedIndex = $conn->real_escape_string($_POST['ratedIndex']);
$ratedIndex++;
$contentid = $conn->real_escape_string($_POST['uID']);


$update = "UPDATE content_feedback_table SET rating_number = '$ratedIndex' WHERE student_id = '$userid' AND content_id = '$contentid'";
$execute = $conn->query($update);

echo "<p>$update</p>";
exit(json_encode(array('id' => $uID)));


}

?>

<!-- This will show the sub content that is associated with the content that student will user to learn  -->
<?php

$getContentInfo = "SELECT * FROM module_content_information WHERE content_id = '$content_id'";
$result = $conn->query($getContentInfo);

while($row=$result->fetch_assoc()) {
  $contentTitle = $row['Title'];
  $description = $row['Information'];


  echo  "<div class='container '>";
  echo  "<div class='container2 '>";
  echo  "<div class='info-title'>";
  echo "<h2 style = 'text-decoration: underline !important'>    $contentTitle </h2>";
  echo "</div>";
  echo  "<div class='container2 '>";
  echo "<p>$description</p>";
  

  echo "</div>";
  echo "</div>";
  echo "</div>";
  
 

  //echo "<p> <a href='student_profile.php?studentid=$student_id'> Student: $first_name  $second_name </a>    </p>";



}

?>

<!-- This is the script so that the feedback option will hide -->
<script>

  $(document).ready(function(){
    $("#hide").click(function(){
      $("#feedback-div").toggle(1000);
    

  

  });

  });

  $(document).ready(function(){
    $("#hide2").click(function(){
      $("#feedback-div-stars").toggle(1000);
    

  

  });

  });

</script>
</body>
</html>




















    

    
    


    










    

    





   






   






    