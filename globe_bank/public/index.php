<?php require_once ('../private/initialize.php'); ?>

<?php 
  //read the page content that is being selected from the nav page
  if(isset($_GET['id'])){
      $page_id = $_GET['id'];
      $page = find_page_by_id($page_id, ['visible' => true]); //sql query from query_functions.php
      if(!$page){
          redirect_to(url_for('/index.php'));
      }
      $subject_id = $page['subject_id'];
      
      $subject = find_subject_by_id($subject_id, ['visible' => true]); // check if subject is visible
      if(!$subject){
          redirect_to(url_for('/index.php'));
      }
      
  }elseif (isset($_GET['subject_id'])) { //collapsing navigation 
      $subject_id = $_GET['subject_id'];
      
      $subject = find_subject_by_id($subject_id, ['visible' => true]); // check if subject is visible
      if(!$subject){
          redirect_to(url_for('/index.php'));
      }
      $page_set = find_pages_by_subject_id($subject_id, ['visible' => true]);
      $page = mysqli_fetch_assoc($page_set); //first page as a default
      mysqli_free_result($page_set);
      if(!$page){
          redirect_to(url_for('/index.php'));
      }
      $page_id = $page['id'];
  } else{
    //nothing selected show the home page  
  }

?>


<?php include(SHARED_PATH . '/public_header.php'); ?>


<div id="main">
    
    <?php include(SHARED_PATH . '/public_navigation.php'); ?>
    
    <div id="page">
        
        <?php
        
        //if we found a page selected from nav display page information
        if(isset($page)){
           $allowed_tags = '<div><h1><img><h2><p><br><strong><em><ul><li>'; //tags specified to use
           echo strip_tags($page['content'], $allowed_tags); //show the page from a database 
        }else{
          //show the home page 
          //homepage content could:
          // * be static content (here or in shared folder)
          // * show the first page from the nav
          // * be in the database but add code to hide in the nav
          include(SHARED_PATH . '/static_homepage.php'); 
        }
        
        ?>
       
        
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
