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

$information_id = $_GET['discussionid'];



// execute the delete statements
$delete = "DELETE FROM content_discussion_forum WHERE discussion_id = '$information_id'";
$deleteLikes = "DELETE FROM likes_table WHERE discussion_id = '$information_id'";
$executeLikes = $conn->query($deleteLikes);
$execute = $conn->query($delete);
echo "$delete";
header("Location:". $return_to);









die;