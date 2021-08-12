





<?php

session_start();


?>

<script>

localStorage.clear();
</script>


<?php 

session_destroy();
header('Location: ../student_level/login_page.php');
exit;

?>