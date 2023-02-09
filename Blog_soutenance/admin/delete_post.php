<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>


<?php
  $postid = $_GET["del_postid"];
  //requête de suppression
  $requete = $db->delete("DELETE FROM post WHERE id='$postid'");
  if($requete)
  {
      echo "<script>alert(\"SUCCESS : post supprimer\")</script>";
  } else {
      //execute requete sql insert into
      echo "<script>alert(\"FAIL : post non supprimer\")</script>";
      
  } 
  include("includes/footer.php");
?>


