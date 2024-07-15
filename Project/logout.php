<?php
// déconnexion par destruction de session
session_start();
$sess_u = $_SESSION['session_util'];
if(session_destroy())
{
// redirection
  header("location:./"); 
}
?>
