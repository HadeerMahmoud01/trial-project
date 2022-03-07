<?php session_start();?>
<?php include"confing.php";?>
<?php

if($_SERVER['REQUEST_METHOD']=="post"){
$email=$_POST['email'];
$password=sha1($_POST['password']);
$statement=$con->prepare("SELECT * FROM `users` WHERE `email`=? AND `password`=? AND `role`!=2");
$statement->exec (array($email,$password));
// $user=$statement->fetch();
// print_r($user);
$Count= $statement->rowCount();
$user=$statement->fetch();
if($Count==1){
  $_SESSION['ID']=$user['id'];
  $_SESSION['EMAIL']=$user['email'];
  $_SESSION['USERNAME']=$user['username'];
  $_SESSION['ROLE']=$user['role'];
  header("location:dashboard.php");

}else{
  echo "you do not have a permission";
}

}






?>
<?php if(isset($_GET['lang'])&& $_GET['lang']=='ar'){
  include "lang/ar.php";
}else{
  include "lang/en.php";
}
if(isset($_GET['lang'])){
  $_SESSION ['lang']=$_GET['lang'];
}
?>
<?php include"includes/header.php";?>
<a href="?lang=en"> English</a> | <a href="?lang=ar"> عربى</a>
<form>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"><?= $lang['email']?></label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label"><?=$lang['password']?></label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  
  <button type="submit" class="btn btn-primary"><?=$lang['login']?></button>
</form>
<?php include"includes/footer.php";?>










