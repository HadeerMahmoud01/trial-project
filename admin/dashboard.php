<?php session_start();?>
<?php include"confing.php";?>
<?php include"includes/header.php";?>
<?php 
if(isset($_SESSION['lang'])&& $_SESSION['lang']=='ar'){
    include "lang/ar.php";
}else{
    include "lang/en.php";
}
?>
<?php include"includes/navbar.php";?>
<?php include"includes/footer.php";?>