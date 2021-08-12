
<?php


// Start the session variables and security of the webpage
// Include the Database Connection
include('dbh.php');
// Get the session to start 
session_start();

// Insert so the page doesnt buffer
ob_start();



   

    






// Check that the page is set

if (isset($_SERVER['HTTP_REFERER'])) {

    $return_to = $_SERVER['HTTP_REFERER'];

} else {

    $return_to= " ../../student_level/login_page.php";
}

//  This will use an OOP style approach used to like the comment 

if (isset($_GET['type']) && isset ($_GET['id']) && isset ($_GET['student'])) {

    if (is_numeric($_GET['id'])) {

        // set the vars needed to check and to insert the data into the database 
        $discussion_id = $_GET['id'];
        $student_id = $_GET['student'];

        // add the check so that the user cannot like the comment more than once


        /*  cCheck if the user has already liked the post in question*/

        $check = "SELECT * FROM likes_table WHERE student_id = '$student_id' AND discussion_id = '$discussion_id'";
        $execute = $conn->query($check);

        $num_rows = $execute->num_rows; 

        if ($num_rows == 0 ) {

    
            // Set the Variables and add them to the database
    
            // Insert the Like into the Database 
            $insert = "INSERT INTO likes_table (student_id, discussion_id) VALUES ('$student_id', '$discussion_id') ";
            $execute = $conn->query($insert);
        } 

        
    
   

        



    }
    
    

}


header("Location:". $return_to);
die;



