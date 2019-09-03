<?php
session_start();
$error ="";
if (array_key_exists('logout',$_GET)){
    unset($_SESSION);
    setcookie("id","",time()-60*60);
    $_COOKIE['id'] = "";
    session_destroy();
} else if( (array_key_exists('id',$_SESSION) && $_SESSION['id']) OR (array_key_exists('id',$_COOKIE) && $_COOKIE['id'])){
        header("location:loggedInPage.php");
}
if (array_key_exists("submit",$_POST)) {
    include("connection.php");
    if (!$_POST['email']){
        $error.="Требуется адрес электронной почты";
    }
    if (!$_POST['password']){
        $error.="Требуется пароль";
    }
    if ($error!==""){
        $error = "<p>Найдены ошибки</p>".$error;
    } else {
        if ($_POST['signUp'] =='1' ) {
        $query = "select id from users where email = '".mysqli_real_escape_string($link,$_POST['email'])."' limit 1";
        $result= mysqli_query($link,$query);
        if (mysqli_num_rows($result)>0) {
            $error = "Такой адрес электронной почты уже занят";
        } else {
                    $query = "INSERT INTO users(email, password) VALUES('".mysqli_real_escape_string(
                        $link,$_POST['email'])."','" .mysqli_real_escape_string($link,$_POST['password'])."')";
                    $result = mysqli_query($link,$query);
                    try{    
                    session_start();
                    }
                    catch(Exception $ex){

                    };
                    $_SESSION['id'] = mysqli_insert_id($link);

                    if (!$result){
                        echo "<p>Couldn't sign you up. Please, try later.</p>";
                    } else {

                        $query= "update users set password ='".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' where id='".mysqli_insert_id($link)."' limit 1";
                        $result = mysqli_query($link,$query);
                        if ($_POST['stayLoggedIn']==1){
                            setcookie('id',mysqli_insert_id($link),time()*60*60*24);
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
                try{
                session_start();
                }
                catch(Exception $ex){

                };
            
                $_SESSION["id"] = $row['id'];

                if ($_POST['stayLoggedIn']==1){
                    setcookie('id',$row['id'],time()*60*60*24);
                    
                }
                header("Location:loggedInPage.php");

            }else {
                $error = "Возможно вы ввели неверный логи и пароль";
    
            }

        }else {
            $error = "Возможно вы ввели неверный логи и пароль";

        }

    }

    }


}
?>
<?php
    include("header.php");
?>
        <div class="container">
            <h1 class="text-secondary">Твои сокровенные тайны</h1>
            <br>
            <p>
            <em class="text-secondary"><strong>Твои самые сокровенные мысли которые останутся в тайне от других... </strong></em>
            </p>
            <br>
            <div id="error" class="text-danger">
                <?php  
                    echo $error;
                ?>
            </div>

            <form method='post' id="signUpForm">
                <p class="text-primary">Интересно? Подпишись сейчас.</p>
                <fieldset class="form-group">    
                    <input class='form-control' type='email' name='email' placeholder="your email">    
                </fieldset>
                <fieldset class="form-group">    
                    <input class='form-control' type='password' placeholder="password" name='password'>
                </fieldset>
                <div class="checkbox">    
                    <label class="text-info">
                        <input class='form-control' type='checkbox' name='stayLoggedIn' checked=true>Не выходить из сеанса
                    </label>
                </div>
                <fieldset class="form-group">    
                    <input class='form-control' type="hidden" name="signUp" value="1">
                </fieldset>
                <fieldset class="form-group">    
                    <input class='btn btn-success' type='submit' name='submit' value='Sign Up'>
                </fieldset>
                <p><a class='toggleForms nav-link text-info'><strong>Войти</strong></a></p>
            </form>

            <form method='post' id="logInForm">
                 <p class="text-primary">Войдите в дневник используя свои логин и пароль</p>

                <div class="form-group">    
                <fieldset class="form-group">    
                    <input class='form-control' type='email' name='email' placeholder="your email">    
                </fieldset>
                <fieldset class="form-group">    
                    <input class='form-control' type='password' placeholder="password" name='password'>
                </fieldset>
                <div class="checkbox">    
                    <label class="text-info">
                        <input class='form-control' type='checkbox' name='stayLoggedIn' checked=true>Не выходить из сеанса
                    </label>
                </div>
                <fieldset class="form-group">    
                    <input class='form-control' type="hidden" name="signUp" value="0">
                </fieldset>
                <fieldset class="form-group">    
                    <input class='btn btn-success' type='submit' name='submit' value='Log In'>
                </fieldset>
                </div>
                <p><a class='toggleForms hoverable text-info'><strong>Создать учетную запись</strong></a></p>
            </form>
        </div>
<?php
include("footer.php");
?>