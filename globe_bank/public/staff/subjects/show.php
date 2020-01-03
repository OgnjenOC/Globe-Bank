<?php

require_once('../../../private/initialize.php');

?>

<?php
//if id index is not being set in the link path
// set id = 1 as default value
//$id = isset($_GET['id']) ? $_GET['id'] : '1'; PHP < 7.0
$id = $_GET['id'] ?? '1'; // PHP > 7.0


//use function_subject_id body logic(query_functions.php) 
//to access database and retrieve subjects data 
$subject = find_subject_by_id($id);



?>

<!-- <a href="show.php?name=<?php echo u('John Doe'); ?>">Link</a><br />
<a href="show.php?company=<?php echo u('Widgets&More'); ?>">Link</a><br />
<a href="show.php?query=<?php echo u('!#*?'); ?>">Link</a><br />

-->

<?php $page_title = 'Show Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <a class="back-link" href="<?php echo 
    url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>
    
    <div class="subject show">
       
        <h1>Subject: <?php echo h($subject['menu_name']); ?></h1> 
        
        <dl>
            <dt>Menu Name</dt>
            <dd> <?php echo h($subject['menu_name']); ?></dd>
        </dl>
        
        <dl>
            <dt>Position</dt>
            <dd> <?php echo h($subject['position']); ?></dd>
        </dl>
        
        <dl>
            <dt>Visible</dt>
            <dd> 
             <?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?>
            </dd>    
        </dl>
  
    </div>
    
</div>


<?php include(SHARED_PATH . '/staff_footer.php'); ?>
