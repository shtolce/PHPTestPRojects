<?php
session_start();
//print_r($_COOKIE);

if (array_key_exists('id',$_COOKIE)){
    $_SESSION['id'] = $_COOKIE['id'];
}
if (array_key_exists('id',$_SESSION)){
    echo "<p>Logged in! <a href='index.php?logout=1'>Log out</a></p>";
}else{



}


?>