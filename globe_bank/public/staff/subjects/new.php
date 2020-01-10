<?php
require_once('../../../private/initialize.php');

if(is_post_request()){

    
    
    // read values that have been submitted by a form 

    $subject['menu_name'] = $_POST['menu_name'] ?? '';
    $subject['position'] = $_POST['position'] ?? '';
    $subject['visible'] = $_POST['visible'] ?? '';
    

    $result = insert_subject($subject);
    
    if($result === true){
         //redirect user to show.php and show new data 
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = 'The subject was created successfully.';
        redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));
    }else{
        $errors = $result;
    }
       
}

$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set) + 1; //count the number of rows from subjects table + 1 that is creating
mysqli_free_result($subject_set);
    
//make highest position as a default
$subject = [];
$subject["position"] = $subject_count;
   
    
   
?>



<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <a class="back-link" href="<?php echo 
  url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>
  
    <div class="subject new">
      <h1>Create Subject</h1>
      
      <?php echo display_errors($errors); ?>
      
      <form action="<?php echo 
      url_for('/staff/subjects/new.php'); ?>" method="POST">
          <!-- dl(data list) tag defines description list -->
          <dl>
               <!-- dt(data term) tag defines terms/names -->
              <dt>Menu Name</dt>
               <!-- dd(data definition) tag defines each term/name -->
               <dd><input type="text" name="menu_name" value=""/></dd>
          </dl>
          
          <dl>
              <dt>Position</dt>
              <dd>
                  <select name="position">
                     <?php
                      //loop through a series of options and check if
                      //position is equal to current value
                      for($i=1; $i <= $subject_count; $i++){
                          echo "<option value=\"{$i}\"";
                          if($subject["position"] == $i){
                              echo " selected";
                          }
                          echo ">{$i}</option>";
                      }
                      ?>
                  </select>
              </dd>
          </dl>
          
          <dl>
              <dt>Visible</dt>
              <dd>
                  <!-- if box is unchecked send false -->
                  <input type="hidden" name="visible" value="0" />
                  <!-- if box is checked send true -->
                  <input type="checkbox" name="visible" value="1" />
              </dd>
          </dl>
          
          <div id="operations">
              <input type="submit" value="Create Subject" />
          </div>
      </form>
      
      
    </div>  
    
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>