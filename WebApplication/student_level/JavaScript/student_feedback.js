var ratedIndex = -1, uID = 0;

$(document).ready(function() {

 


    resetStarColours();
    
    if (localStorage.getItem('ratedIndex') !=null)
    setStars(parseInt(localStorage.setItem('ratedIndex', ratedIndex)));
    uId = localStorage.getItem('uID');
    
    
    // Mouse onClick
  $('.fa-star').on('click', function() {

    ratedIndex = parseInt($(this).data('index'));
    localStorage.setItem('ratedIndex', ratedIndex);
    saveToDB();
    

  });

  

//   Mouse over function
  $('.fa-star').mouseover(function(){

    resetStarColours();

    var currentIndex = parseInt($(this).data('index'));

    setStars(currentIndex);


    
    
  });
  
  
  
  
  
  
  
  
  
  // Mouse off Function
  $('.fa-star').mouseleave(function() {
    resetStarColours();


    if (ratedIndex != -1)
    setStars(ratedIndex);





  });





  
  
});
// Set Stars Function
function setStars(max) {

  if (ratedIndex != -1)
    for (var i=0; i <=max; i++) 
    $('.fa-star:eq('+i+')').css('color', 'yellow');
}

// default stars function
function resetStarColours() {
  $('.fa-star').css('color', 'white')
}


// Send to the database function 




function saveToDB() {
  $.ajax({
    url: "student_feedback.php", 
    method: "POST",
    dataType: 'json', 
    data:{
      
      
      ratedIndex: ratedIndex
    }, success: function (r) {
      uID = r.uid;
      localStorage.setItem('ratedIndex', ratedIndex);

    }

  });

}


<!-- Used to send the rating to the Database -->
<?php 


if (isset($_POST['save'])) {
  $ratedIndex = $conn->real_escape_string($_POST['ratedIndex']);

  
  $comment = $_POST['comments'];
  
  

  echo "<p> Check </p>";

    $insert = "INSERT INTO content_feedback_table (content_id, student_id, rating_number) VALUES ('$content_id', '$userid', '$ratedIndex') ";
    $execute = $conn->query($insert);

    print_r($insert);

  
    /*$update = "UPDATE content_feedback_table SET rating_number=$ratedIndex WHERE student_id = $userid";
    $execute = $conn->$query($update);*/  

  

  

}


?>