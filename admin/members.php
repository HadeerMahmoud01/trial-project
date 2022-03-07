<?php session_start();?>
<?php include"confing.php";?>
<?php include"includes/header.php";?>
<?php include"includes/navbar.php";?>

<?php
if(isset($_GET['action'])){
    $do=$_GET['action'];
}else{
    $do="index";


}
?>
<?php if($do=="index"):?>
<h1> hello from index page </h1>



<?php 
$statement=$con->prepare("SELECT * FROM `users`");
$statement->exec();
$users=$statement->fetchall();
?>
<div class="container">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">user name</th>
      <th scope="col">created_at</th>
     <td>
       <?php if($_SESSION['Role']==3):?>
  <button type="button" class="btn btn-danger" href="?action=show&userid=<?=$user[`id`]?>">show</button>
  <?php else: ?>
    <button type="button" class="btn btn-danger" href="?action=show&userid=<?=$user[`id`]?>">show</button>
  <button type="button" class="btn btn-warning" href="?action=edit&userid=<?=$user[`id`]?>">edit</button>
  <!-- <button type="button" class="btn btn-success>delete</button> -->
<!-- new button -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$user['id']?>">
  delete
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal <?=$user['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" href="?action=delete&userid=<?=$user['id']?>">Yes</button>
      </div>
    </div>
  </div>
</div>

<?php endif?>



</td>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($users as $user):?>
    <tr>
      <th scope="row"><?=$user['id']?></th>
      <td><?=$user['username']?></td>
      <td><?=$user['created_at']?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
</div>


<?php elseif($do== "create"):?>
     <h1> Add users </h1>
<form method="post" action="?action=store">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">phone</label>
    <input type="number" class="form-control"  name="phone">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">username</label>
    <input type="text" class="form-control" name="username">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>












<?php elseif($do== "store"):?>
  <?php if($_SERVER['REQUEST_METHOD']=='post'){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $phone=$_POST['phone'];
    $statement=$con->prepare("INSERT INTO `users`(`email`, `username`,`password`,`role`,`phone`,`img`,`created_at`) 
    VALUES (?,?,?,2,?,null,now())");
    $statement->exec(array($email,$username,$password,$phone));
    header("location:members.php");
  }else{
    echo"sorry";
  }

?>




  <?php elseif($do== "edit"):?>
    <?php
    $userid=$_GET['userid'];
    $statement=$con->prepare("SELECT * FROM `users`");
$statement->exec();
$users=$statement->fetch();
$count=$statement->rowcount();
?>
    <h1> edit users </h1>
    <?php if($count==1):?>
<form method="post" action="?action=update">
<input type="number" class="form-control"  name="id" value="<?=$user['id']?>" hidden>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?=$user['useremail']?>">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="newpassword">
    <input type="password" class="form-control" id="exampleInputPassword1" name="oldpassword" value="<?=$user['password']?>">
  </div>
  <div class="mb-3">
    <label  class="form-label">phone</label>
    <input type="number" class="form-control"  name="phone" value="<?=$user['useremail']?>">
  </div>
  <div class="mb-3">
    <label  class="form-label">username</label>
    <input type="text" class="form-control" name="username" value="<?=$user['username']?>">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php else:?>
   <script>window.history.back();</script>
  <?php endif?>
<?php elseif($do== "update"):?>
     <h1> hello from update page </h1>
<?php elseif($do== "show"):?>
<?php 
if($_SERVER['REQUEST_METHOD']='post'){
  $userid=$_POST['id'];
$username=$_POST['username'];
$email=$_POST['email'];
$phone=$_POST['phone'];
if(!empty($_POST['newpassword'])){
  $password=$_POST['newpassword'];
}else{
  $password=$_POST['oldpassword'];
}
$statement=$con->prepare("UPDATE `users` SET `email`=?,`username`='?,`phone`=?,`password`=? WHERE `id`=?");
$statement->exec(array($email,$username,$phone,$password,$userid));
header("location:memembers.php");
}

?>


  
<?php elseif($do== "delete"):?>
     <h1> hello from delete page </h1>
<?php 
$userid=$_GET['userid'];
$statement=$con->prepare("DELETE FROM `users` WHERE `id`=?");
$statement->exec(array($userid));
?>




   <?php else: ?>
       <h1> error 404</h1>
       <?php endif ?>
























<?php include"includes/footer.php";?>

