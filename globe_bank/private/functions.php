<?php
    
function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

//shorten our urlencode for easier usage
function u($string=""){
    return urlencode($string);
}

//shorten our rawurlencode for easier usage
function raw_u($string=""){
    return rawurlencode($string);
}

//shorten our htmlspecialchars for easier usage that protects 
//us from cross site scripting attacks 
function h($string=""){
    return htmlspecialchars($string);
}

function error_404() {
    //using the 404 error with required built in header function
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    //quit and dont do any additional PHP
    exit();
}

function error_500() {
    //using the 500 error with required built in header function
     header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    //quit and dont do any additional PHP
    exit();
}

function redirect_to($location){
    header("Location: " . $location); 
    exit();
}

//checking if form request is POST
function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

//checking if form request is GET
function is_get_request(){
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

//show form validation errors 
function display_errors($errors=array()){
    $output = '';
    if(!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach($errors as $error){
            $output .= "<li>" . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    
    return $output;
}

//checks to see if there is a message set and if is not empty
//assigns the value to a variable $msg 
//unset the SESSION and returns a session message variable
function get_and_clear_session_message(){
  if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
      $msg = $_SESSION['message'];
      unset($_SESSION['message']);
      return $msg;
  }
}

//display the session status message on the page
function display_session_message(){
    $msg = get_and_clear_session_message();
    if(!is_blank($msg)){
        return '<div id="message">' . h($msg) . '</div>';
    }
}

?>
