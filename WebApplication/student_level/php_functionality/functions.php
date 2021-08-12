<?php 


public class  GetFunction{ 

        // Use the method here 
        function getLike($user_id, $discussion_id) {
        //   The get like function that will be used in tutor_discussion_forum.php and student_discussion_forum.php
        // include the db connecyion in the file
        include('../student_level/dbh.php');
    
        $selectLikes = "SELECT * FROM likes_table WHERE student_id OR tutor_id = '$user_id' AND discussion_id ='$discussion_id'";
        $execute = $conn->query($selectLikes);
    
        // The number of likes will be determined by the the number of rows that exist in the likes table that will equal 
    
        $num_rows = $execute->num_rows; 
    
        $likes = $num_rows;
    
        return; 
    
      
    
    
      }
}



    
    






















  


?>