<?php
//load the initialize.php file content only once
//we use .. path template because in the initialize.php file 
//we have our paths defined 
require_once('../../../private/initialize.php');

?>

<?php
    //use function logic(query_functions.php) 
    //to access database and retrieve pages data 
    $page_set = find_all_pages();

?>


<?php 
//set a text for a title of the page and assign it into a variable
$page_title = 'Pages'; ?>

<?php 
//load the reusable header code into our current page with
//assigned path from the initialize.php file
include(SHARED_PATH . '/staff_header.php'); 
?>

<div id="content">
    <div class="pages listing">
      <h1>Pages</h1>
        
    <div class="actions">
      <a class="action" href="<?php echo 
        url_for('/staff/pages/new.php'); ?>">Create New Page</a>
    </div>
        
      <table class="list">
        <tr>
          <th>ID</th>
          <th>Subject ID</th>
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
      while($page = mysqli_fetch_assoc($page_set)) { ?>
        
        <tr>
          <td><?php echo h($page['id']); ?></td>
          <td><?php echo h($page['subject_id']); ?></td>
          <td><?php echo h($page['position']); ?></td>
          <td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
          <td><?php echo h($page['menu_name']); ?></td>
         
          <td><a class="action" href="<?php echo 
          //id=' . $subject['id'] builds up a string and create different link 
          //for each id number
          url_for('staff/pages/show.php?id= ' . h(u($page['id'])));
          ?>">View</a></td>
          <td><a class="action" href="<?php echo 
          //look up for the id number selected for updating 
          url_for('/staff/pages/edit.php?id=' . h(u($page['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo 
            url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>">Delete</a></td>
        </tr>
    <?php } ?>
      </table>
      
      <?php
      //clear up the data fetched from the database
      mysqli_free_result($page_set);
      
      ?>
      
    </div>
</div>


<?php 
//load the reusable footer code into our current page with 
//assigned path variable from the initialize.php file
include(SHARED_PATH . '/staff_footer.php'); 
?>
