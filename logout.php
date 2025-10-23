<?php 
if(isset($_SESSION))
{
    unset($_SESSION);
    session_destroy();
}
//header("location: /cp/");
echo("<script>location.href='/home';</script>");
die();
?>