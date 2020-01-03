<?php
//load the initialize.php file content only once
//we use .. path template because in the initialize.php file 
//we have our paths defined 
require_once('../../private/initialize.php');
?>

<?php 
//set a text for a title of the page and assign it into a variable
$page_title = 'Staff menu'; ?>

<?php 
//load the reusable header code into our current page with
//assigned path from the initialize.php file
include(SHARED_PATH . '/staff_header.php'); 
?>
  
<div id="content">
    <div id="main-menu">
       <h2>Main Menu</h2>
        
       <ul>
        <li><a href="<?php echo url_for('staff/subjects/index.php');
         ?>">Subjects</a></li>
        <li><a href="<?php echo url_for('staff/pages/index.php');
         ?>">Pages</a></li>
       </ul>
       
    </div>    
</div>

<?php 
//load the reusable footer code into our current page with 
//assigned path variable from the initialize.php file
include(SHARED_PATH . '/staff_footer.php'); 
?>
  

