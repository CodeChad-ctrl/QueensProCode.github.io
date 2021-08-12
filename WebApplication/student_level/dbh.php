<!-- This is the database connection file -->


<?php
// decalre the password 
$pw = "QhmBvZm5lfpzwzGw";

// decalre the MySqli user name 
$user = "rsmyth53";

// declare the database 
$db = "rsmyth53";

// decalre the webserver 
$webserver = "rsmyth53.lampt.eeecs.qub.ac.uk";

$conn = mysqli_connect($webserver, $user, $pw, $db);

if($conn -> connect_error){
    echo '$conn->connect_error';
} else {
    
}