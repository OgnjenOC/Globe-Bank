<?php require_once ('../private/initialize.php'); ?>

<?php 
  //read the page content that is being selected from the nav page
  if(isset($_GET['id'])){
      $page_id = $_GET['id'];
      $page = find_page_by_id($page_id); //sql query from query_functions.php
      if(!$page){
          redirect_to(url_for('/index.php'));
      }
      $subject_id = $page['subject_id'];
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
           //show the page from a database
           //TODO add html escaping back in  
           echo $page['content']; 
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
