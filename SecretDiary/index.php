<?php
session_start();
$error ="";
if (array_key_exists('logout',$_GET)){
    unset($_SESSION);
    setcookie("id","",time()-60*60);
    
    $_COOKIE['id'] = "";
} else {
    if( (array_key_exists('id',$_SESSION) AND $_SESSION['id']) OR (array_key_exists('id',$_COOKIE) AND $_COOKIE['id'])){
        header("location:loggedInPage.php");
    }
}
if (array_key_exists("submit",$_POST)) {
    $link = mysqli_connect($host = 'shareddb-q.hosting.stackcp.net','secretdi-3131371054','ell10axuav','secretdi-3131371054');
    if(mysqli_connect_error()) {
        die("database connection error");
    }
    if (!$_POST['email']){
        $error.="An email address is required";
    }
    if (!$_POST['password']){
        $error.="A password is required";
    }
    if ($error!=""){
        $error = "<p>There was an error in your form</p>".$error;
    } else {
        if ($_POST['singUp'] ==1 ) {
        $query = "select id from users where email = '".mysqli_real_escape_string($link,$_POST['email'])."' limit 1";
        $result= mysqli_query($link,$query);
        if (mysqli_num_rows($result)>0) {
            $error = "That email address is taken";
        } else {
                    $query = "INSERT INTO users(email, password) VALUES('".mysqli_real_escape_string(
                        $link,$_POST['email'])."','" .mysqli_real_escape_string($link,$_POST['password'])."')";
                    $result = mysqli_query($link,$query);
                    if (!$result){
                        echo "<p>Couldn't sign you up. Please, try later.</p>";
                    } else {
                        $query= "update users set password ='".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' where id='".mysqli_insert_id($link)."' limit 1";
                        $result = mysqli_query($link,$query);
                        $_SESSION['id'] = mysqli_insert_id($link);
                        if ($_POST['stayLoggedIn']==1){
                            setcookie('id',mysqli_insert_id($link),time()*60*60);
                        }
                        header("Location:loggedInPage.php");

                    }

        }
    }else {  //if signup
        $query = "select * from users where email = '".mysqli_real_escape_string($link,$_POST['email'])."' limit 1";
        $result= mysqli_query($link,$query);
        $row= mysqli_fetch_array($result);
        if (isset($row)) { 
            $sharedPassword = md5(md5($row['id']).$_POST['password']);
            if ($sharedPassword == $row['password']) {
                $_SESSION["id"] = $row['id'];
                if ($_POST['stayLoggedIn']==1){
                    setcookie('id',$row['id'],time()*60*60);
                }
                header("Location:loggedInPage.php");

            }else {
                $error = "That email/password couldn't be found";
    
            }

        }else {
            $error = "That email/password couldn't be found";

        }

    }

    }


}

?>
<html>
<div id="error">
    <?php  
        echo $error;
    ?>
</div>

<form method='post'>
    <input type='email' name='email' placeholder="your email">    
    <input type='password' placeholder="password" name='password'>
    <input type='checkbox' name='stayLoggedIn' checked=true>
    <input type="hidden" name="singUp" id="1">
    <input type='submit' name='submit' value='Sign Up'>
</form>

<form method='post'>
    <input type='email' name='email' placeholder="your email">    
    <input type='password' placeholder="password" name='password'>
    <input type='checkbox' name='stayLoggedIn' checked=true>
    <input type="hidden" name="singUp" id="0">
    <input type='submit' name='submit' value='Log In'>
</form>



</html>