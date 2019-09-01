<?php

session_start();
$_SESSION['user'] = 'Percival';
//echo $_SESSION['user'];
if (array_key_exists('email',$_SESSION)) {
echo "Вы вошли в систему".$_SESSION['email'];

}
else{
    header("Location: index.php");

}


?>