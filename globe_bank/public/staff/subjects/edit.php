<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/subjects/index.php'));
}

$id = $_GET['id'];

if(is_post_request()){

    // handle values that have been submitted by a form from new.php
    $subject = [];
    
    $subject['id'] = $id;
    
    $subject['menu_name'] = $_POST['menu_name'] ?? '';
    $subject['position'] = $_POST['position'] ?? '';
    $subject['visible'] = $_POST['visible'] ?? '';

    $result = update_subject($subject); //query_functions.php UPDATE
    
    if($result === true){
        redirect_to(url_for('staff/subjects/show.php?id=' . $id));
    }else{
        $errors = $result;
        //var_dump($errors);
    }
    
}else{
    //use function_subject_id body logic(query_functions.php) 
    //to access database and retrieve subjects data 
    $subject = find_subject_by_id($id);
}

$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set); //count the number of rows from subjects table
mysqli_free_result($subject_set);

?>


<?php $page_title = 'Edit Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <a class="back-link" href="<?php echo 
  url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>
  
    <div class="subject edit">
      <h1>Edit Subject</h1>
      
      <?php echo display_errors($errors); ?>
      
      <form action="<?php echo 
      url_for('/staff/subjects/edit.php?id=' . h(u($id))); ?>" method="POST">
          <!-- dl(data list) tag defines description list -->
          <dl>
               <!-- dt(data term) tag defines terms/names -->
              <dt>Menu Name</dt>
               <!-- dd(data definition) tag defines each term/name -->
               <dd><input type="text" name="menu_name" value="<?php echo
               h($subject['menu_name']); ?>" /></dd>
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
                          if($subject['position'] == $i){
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
                  <input type="checkbox" name="visible" value="1"
                  <?php if($subject['visible'] == 1){
                  echo 'checked';} ?> />
              </dd>
          </dl>
          
          <div id="operations">
              <input type="submit" value="Edit Subject" />
          </div>
      </form>
      
      
    </div>  
    
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>