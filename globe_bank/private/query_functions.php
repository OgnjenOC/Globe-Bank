<?php

function find_all_subjects($options=[]){
    //access $db variable to be used in function scope
    global $db;
    
    //check passed values
    $visible = $options['visible'] ?? false;
    
    //retrieve subjects data from data base using mysqli
    //must have space at the end of line if we are concatenating
    $sql = "SELECT * FROM subjects ";
    
    //retrieve only visible = true subjects
    if($visible){
        $sql .= "WHERE visible = true ";
    }
    
    //concatenate line with .= 
    $sql .= "ORDER BY position ASC";
    //echo $sql; is a good practise to troubleshoot query created
    
    

    //return a data set to work with 
    $result = mysqli_query($db, $sql);
    
    //check if query returns set of data 
    //using function from database.php file
    confirm_result_set($result);
    
    return $result;
}

function find_all_pages(){
    //access $db variable to be used in function scope
    global $db;
    
    //retrieve pages data from data base using mysqli
    //must have space at the end of line if we are concatenating
    $sql = "SELECT * FROM pages ";
    //concatenate line with .= 
    $sql .= "ORDER BY subject_id,position ASC";
    //echo $sql; is a good practise to troubleshoot query created
    
    

    //return a data set to work with 
    $result = mysqli_query($db, $sql);
    
    //error check if query returns set of data 
    //using function from database.php file
    confirm_result_set($result);
    
    return $result;
}

//returns a single subject row from database 
function find_subject_by_id($id, $options=[]){
   
    global $db;  //access $db variable to be used in function scope
    
    //check passed values
    $visible = $options['visible'] ?? false;
    
    $sql = "SELECT * FROM subjects ";

    //concatenate line with .= 
    //always put single quotes around values good practise to prevent SQL injection
    $sql .= "WHERE id='" . db_escape($db, $id) ."' "; //db_escape is a function inside database.php to prevent SQL injection
    
    //retrieve only visible = true subjects
    if($visible){
        $sql .= "AND visible = true";
    }
    
    $result = mysqli_query($db, $sql);
    
    confirm_result_set($result); //test if query entire result failed 
    
     
    $subject = mysqli_fetch_assoc($result); //grab returned data as associative array
    
    mysqli_free_result($result); //release returned data
    
    return $subject; //return an associative array 
    
}

function find_page_by_id($id, $options=[]){
    
    global $db;
   
    //check passed values
    $visible = $options['visible'] ?? false;
    
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    //retrieve only visible = true subjects
    if($visible){
        $sql .= "AND visible = true";
    }
    $result = mysqli_query($db, $sql);
    
    confirm_result_set($result);
    
    $page = mysqli_fetch_assoc($result);
    
     mysqli_free_result($result);
    
    return $page;
}

function find_pages_by_subject_id($subject_id, $options=[]){
    
    global $db;
    
    //check passed values
    $visible = $options['visible'] ?? false;
    
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
    
    //retrieve only visible = true subjects
    if($visible){
        $sql .= "AND visible = true ";
    }
    $sql .= "ORDER BY position ASC";
    $result = mysqli_query($db, $sql);
    
    confirm_result_set($result);
    
    return $result;
}

function insert_subject($subject){
    
    global $db;
    
    $errors = validate_subject($subject); //validate associative array
    
    if(!empty($errors)){
        return $errors;
    }
    
    $sql = "INSERT INTO subjects ";
    $sql .= "(menu_name, position, visible) ";
    $sql .= "VALUES (" ;
    $sql .=  "'" . db_escape($db, $subject['menu_name']) . "',"; //single quotes prevent SQL injections
    $sql .=  "'" . db_escape($db, $subject['position']) . "',";
    $sql .=  "'" . db_escape($db, $subject['visible']) . "'";
    $sql .= ")";
    
    //for INSERT statements result is true/false
    $result = mysqli_query($db, $sql);
    
    //check insert connection
    if($result){
        return true;   
    }else{
        //failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
    
}

function insert_page($page){
    
    global $db;
    
    $errors = validate_page($page);
    
    if(!empty($errors)){
        return $errors;
    }
    
    $sql = "INSERT INTO pages ";
    $sql .= "(subject_id, menu_name, position, visible, content) ";
    $sql .= "VALUES (";
    $sql .=  "'" . db_escape($db, $page['subject_id']) . "',";
    $sql .=  "'" . db_escape($db, $page['menu_name']) . "',"; //single quotes prevent SQL injections
    $sql .=  "'" . db_escape($db, $page['position']) . "',";
    $sql .=  "'" . db_escape($db, $page['visible']) . "',";
    $sql .=  "'" . db_escape($db, $page['content']) . "'";
    $sql .= ")";
    
    //for INSERT statements result is true/false
    $result = mysqli_query($db, $sql);
    
    //check insert connection
    if($result){
        return true;   
    }else{
        //failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
    
}

function update_subject($subject){
    global $db;
    
    
    $errors = validate_subject($subject); //validate associative array
    
    if(!empty($errors)){
        return $errors;
    }
    
    $sql = "UPDATE subjects SET ";
    $sql .= "menu_name='" . db_escape($db, $subject['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db, $subject['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $subject['visible']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
    $sql .= "LIMIT 1"; //update query to only one row 
    
    $result = mysqli_query($db, $sql); // for update $result is true/false
    
    
    if($result){
        return true;
    }else{
        //failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_page($page){
    global $db;
    
    $errors = validate_page($page);
    
    if(!empty($errors)){
        return $errors;
    }
    
    $sql = "UPDATE pages SET ";
    $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
    $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db, $page['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
    $sql .= "content='" . db_escape($db, $page['content']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
    $sql .= "LIMIT 1";
    
    $result = mysqli_query($db, $sql); // for update $result is true/false
    
    
    if($result){
        return true;
    }else{
        //failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
    
}

function delete_subject($id){
    
    global $db;
    
    $sql = "DELETE FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
  
    $result = mysqli_query($db, $sql);
  
  
    //for DELETE statements result is true/false
    if($result){
      return true;
    } else{
    //failed
    echo mysqli_error($db);
    db_disconnect($db);
     exit;
    }
}

function delete_page($id){
    
    global $db;
    
    $sql = "DELETE FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
  
    $result = mysqli_query($db, $sql);
  
  
    //for DELETE statements result is true/false
    if($result){
      return true;
    } else{
    //failed
    echo mysqli_error($db);
    db_disconnect($db);
     exit;
    }
}

function validate_subject($subject){
    
    $errors = [];
    
    //menu_name
    if(is_blank($subject['menu_name'])){
        $errors[] = "Name cannot be blank";
    }elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])){
        $errors[] = "Name must be between 2 and 255 characters.";
    }
    
    //position
    $position_int = (int) $subject['position'];
    if($position_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if($position_int > 999){
        $errors[] = "Position must be less than 999.";
    }
    
    //visible 
    //check if it is workin with string 
    $visible_str = (string) $subject['visible'];
    if(!has_inclusion_of($visible_str, ["0","1"])){
        $errors[] = "Visible must be true or false.";
    }
    
    return $errors;
    
}

function validate_page($page){
    
    $errors = [];
    
    //subject_id
    $subjectId_int = (int) $page['subject_id'];
    if($subjectId_int <= 0) {
        $errors[] = "Subject ID must be greater than zero.";
    }
    if($subjectId_int > 999){
        $errors[] = "Subject ID must be less than 999.";
    }
    
    //menu_name
    if(is_blank($page['menu_name'])){
        $errors[] = "Name cannot be blank";
    }elseif(!has_length($page['menu_name'], ['min' => 2, 'max' => 255])){
        $errors[] = "Name must be between 2 and 255 characters.";
    }
    //position
    $position_int = (int) $page['position'];
    if($position_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if($position_int > 999){
        $errors[] = "Position must be less than 999.";
    }
    
    //visible 
    //check if it is workin with string 
    $visible_str = (string) $page['visible'];
    if(!has_inclusion_of($visible_str, ["0","1"])){
        $errors[] = "Visible must be true or false.";
    }
    //content
    if(is_blank($page['content'])){
        $errors[] = "Content cannot be blank";
    }
    
    return $errors;
}



?>