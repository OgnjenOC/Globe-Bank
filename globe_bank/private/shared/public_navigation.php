<?php
  //default values to prevent errors
  $page_id = $page_id ?? '';
  $subject_id = $subject_id ?? '';
  $visible = $visible ?? true;
?>


<navigation>
     
    <?php 
    //returns all the subjects from a database
    $nav_subjects = find_all_subjects(['visible' => $visible]); 
    
    ?>
    <ul class="subjects">
      <?php while($nav_subject = mysqli_fetch_assoc($nav_subjects)) { ?>
      <?php// if(!$nav_subject['visible']) { continue; } //if subject is false do not show ?>  
      <li class="<?php if($nav_subject['id'] == $subject_id){
                  echo 'selected';} ?>">
          <a href="<?php echo url_for('index.php?subject_id=' . 
                  h(u($nav_subject['id']))); ?>">
              <?php echo h($nav_subject['menu_name']); 
              ?>
            </a>
                
   <?php if($nav_subject['id'] == $subject_id){ ?>
                <?php $nav_pages = find_pages_by_subject_id($nav_subject['id'], 
                        ['visible' => true]); ?>
                <ul class="pages">
                  <?php while($nav_page = mysqli_fetch_assoc($nav_pages)) {?>
                  <?php //if(!$nav_page['visible']) { continue; } //if page is false do not show ?>  
                  <li class="<?php if($nav_page['id'] == $page_id){echo 'selected';} ?>">
                    <!-- send the URL parameter from a nav page to a database to read a page content  -->  
                    <a href="<?php echo url_for('index.php?id='. h(u($nav_page['id']))); ?>">
                    <?php echo h($nav_page['menu_name']); ?>
                    </a>
                  </li>
        
                <?php } // while $nav_pages ?>
                </ul>
                <?php mysqli_free_result($nav_pages); ?>
                <?php } //if($nav_subject['id'] == $subject_id ?>
      </li>
        
       <?php } // while $nav_subjects ?>
      
    </ul>
    <?php mysqli_free_result($nav_subjects); ?>
   
</navigation>
