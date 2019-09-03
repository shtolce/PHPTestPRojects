<?php
session_start();
//$diarycontent = "";
if (array_key_exists('id',$_COOKIE) && $_COOKIE['id'] ){
    $_SESSION['id'] = $_COOKIE['id'];
}

if (array_key_exists('id',$_SESSION) && $_SESSION['id']){


    include("connection.php");
    $query= "select diary from users where id=". mysqli_real_escape_string($link,$_SESSION['id'])." limit 1";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_array($result);
    $diarycontent= $row['diary'];

}else{
    header("Location: index.php");
}
?>
<?php
include("header.php");
?>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <a class="navbar-brand" href="#"><h5>Твой Личный Дневник<h5></a>
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php?logout=1">Выйти <span class="sr-only">(current)</span></a>
      </li>
    </ul>
</nav>
<div class="container">
    <div class="form-group">
        <label for="diary" class="text-secondary"><h4><strong>Твои тайные мысли и заметки</strong></h4></label>
        <textarea id="diary" class="form-control bg-light" name="" rows="17">
        <?php 
        echo $diarycontent;
        ?>
        
        </textarea>
    </div>

<em class="text-warning fixed-bottom">Запиши здесь все что ты хотел бы оставить в секрете.</em>
</div>
<?php
include("footer.php");
?>
