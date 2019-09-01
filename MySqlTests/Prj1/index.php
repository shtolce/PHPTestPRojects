<?php
/*
//mysqli_connect("mysql.stackcp.com","shtolce","shtolce11021980");
//mysqli_connect("mysql.stackcp.com","shtolce@UsersDb-313137aa60","shtolce11021980","UsersDb-313137aa60",53134);
$con = mysqli_connect($host = 'shareddb-q.hosting.stackcp.net','shtolce','shtolce11021980','UsersDb-313137aa60');
//mysqli_connect($host = 'mysql.stackcp.com',$user='shtolce',$password= 'shtolce1021980',$database='UsersDb-313137aa60',$port='52673');
$str = mysqli_connect_error();
//echo mb_detect_encoding($str);
$str2 = mb_convert_encoding($str, "UTF-8", "cp1251");
echo $str2;
if (!$str2) echo "Database connection successful";

$query = "INSERT INTO users(email, password) VALUES('kirstent@yandex.ru', 'kirst123')";
$q= mysqli_query($con,$query);
echo mysqli_error($con);

$query = "update users set email='suko@mail.ru' where id=3 limit 1";
$q= mysqli_query($con,$query);
echo mysqli_error($con);
*/

/*
$query = 'select * from users';
if ($result = mysqli_query($con,$query)) {
    $row =mysqli_fetch_array($result);
    $row =mysqli_fetch_array($result);
    echo ($row['id'].' '.$row['email'].' '.$row['password']);

}

$query = 'select * from users';
if ($result = mysqli_query($con,$query)) {
    while($row =mysqli_fetch_array($result)){

        print_r($row);
    }
//    echo ($row['id'].' '.$row['email'].' '.$row['password']);

}

*/
session_start();

$con = mysqli_connect($host = 'shareddb-q.hosting.stackcp.net','shtolce','shtolce11021980','UsersDb-313137aa60');

if (array_key_exists('email',$_POST) OR array_key_exists('password',$_POST)){
    if ($_POST['email']=='') {
        echo '<p>email required</p>';
    }
    else if ($_POST['password']=='') {
        echo '<p>password required</p>';
    }
    else {
        $str = mysqli_connect_error();
        $str2 = mb_convert_encoding($str, "UTF-8", "cp1251");
        
        $query = "select id from users where email = '". mysqli_real_escape_string($con,$_POST['email'])."'";
        $result= mysqli_query($con,$query);
        
        if (mysqli_num_rows($result)>0){
            echo '<p>this email has already been taken</p>';

        }else {
            $query = "INSERT INTO users(email, password) VALUES('".mysqli_real_escape_string(
                $con,$_POST['email'])."','" .mysqli_real_escape_string($con,$_POST['password'])."')";
            $result = mysqli_query($con,$query);
            if ($result){
                $_SESSION['email'] = $_POST['email'] ;
                header("Location: session.php");
                echo 'you have been signed up';
            }
        }

    

    }


    

}



?>
<form method='post'>
<input type='text' name='email' placeholder='email address'>
<input type='text' name='password' placeholder='password' type='password'>
<input type='submit' value='sign up'>


</form>
