<?php
//load the initialize.php file content only once
//we use .. path template because in the initialize.php file 
//we have our paths defined 
require_once('../../../private/initialize.php');

?>

<?php

//use function logic(query_functions.php) 
//to access database and retrieve subjects data 
$subject_set = find_all_subjects();

?>

<?php 
//set a text for a title of the page and assign it into a variable
$page_title = 'Subjects'; ?>

<?php 
//load the reusable header code into our current page with
//assigned path from the initialize.php file
include(SHARED_PATH . '/staff_header.php'); 
?>
  
<div id="content">
  <div class="subjects listing">
    <h1>Subjects</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/subjects/new.php');?>">Create New Subject</a>
    </div>

  	<table class="list">
  	 <tr>
            <th>ID</th>
            <th>Position</th>
            <th>Visible</th>
  	    <th>Name</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
            <th>&nbsp;</th>
  	 </tr>

      <?php 
      //loop through database table subjects as 
      //an associative array using while loop
      //and ask for the values inside the table which is id,position,visible and menu name 
      while($subject = mysqli_fetch_assoc($subject_set)) { ?>
         <tr>
            <td><?php echo h($subject['id']); ?></td>
            <td><?php echo h($subject['position']); ?></td>
            <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo h($subject['menu_name']); ?></td>
            <td><a class="action" href="<?php echo
            //id=' . $subject['id'] builds up a string and create different link 
            //for each id number
            url_for('/staff/subjects/show.php?id=' . h(u($subject['id'])));
            ?>">View</a></td>
            <!--  go to the edit php page & look up existing record
            from database for an update -->
            <td><a class="action" href="<?php echo 
            url_for('/staff/subjects/edit.php?id=' . h(u($subject['id']))); ?>">Edit</a></td>
            <td><a class="action" href="<?php echo 
            url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>">Delete</a></td>
    	 </tr>
      <?php } ?>
  	</table>
    
      <?php
      //clear up the data fetched from the database
      mysqli_free_result($subject_set);
      
      ?>

  </div>
</div>

<?php 
//load the reusable footer code into our current page with 
//assigned path variable from the initialize.php file
include(SHARED_PATH . '/staff_footer.php'); 
?>
