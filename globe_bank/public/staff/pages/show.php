<?php
require_once('../../../private/initialize.php');


//if id index is not being set in the link path
// set id = 1 as default value
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$page = find_page_by_id($id);

?>

<?php 
//set a text for a title of the page and assign it into a variable
$page_title = 'Show Page'; ?>

<?php 
//load the reusable header code into our current page with
//assigned path from the initialize.php file
include(SHARED_PATH . '/staff_header.php'); 
?>
  
<div id="content">
    
    <a class="back-link" href="<?php echo url_for('/staff/pages/index.php');
    ?>">&laquo; Back to List</a>
 
    <div class="page show">
        
        <h1>Page: <?php echo h($page['menu_name']); ?></h1>
        <div class="attributes">
            <?php $subject = find_subject_by_id($page['subject_id']);?>
        <dl>
            <dt>Subject</dt>
            <dd> <?php echo h($subject['menu_name']); ?></dd>
        </dl>
        
        <dl>
            <dt>Menu Name</dt>
            <dd> <?php echo h($page['menu_name']); ?></dd>
        </dl>
        
        <dl>
            <dt>Position</dt>
            <dd> <?php echo h($page['position']); ?></dd>
        </dl>
        
        <dl>
            <dt>Visible</dt>
            <dd> <?php echo $page['visible'] == 1 ? 'true' : 'false' ; ?></dd>
        </dl>
            
        <dl>
            <dt>Content</dt>
            <dd> <?php echo h($page['content']); ?></dd>
        </dl>
        </div>
    </div>    
</div>

<?php 
//load the reusable footer code into our current page with 
//assigned path variable from the initialize.php file
include(SHARED_PATH . '/staff_footer.php'); 
?>

