<?php 
if(isset($_SESSION))
{
    unset($_SESSION);
    session_destroy();
}
//header("location: /cp/");
echo("<script>location.href='/cp/login';</script>");
die();

?>