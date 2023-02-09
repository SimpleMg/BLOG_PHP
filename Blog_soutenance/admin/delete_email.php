
<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<?php
  $email_id = $_GET["id"];
  //requête de suppression
  $requete = $db->delete("DELETE FROM contact WHERE id='$email_id'");
  if($requete)
  {
      echo "<script>alert(\"SUCCESS : email supprimer\")</script>";
  } else {
      //execute requete sql insert into
      echo "<script>alert(\"FAIL : email non supprimer\")</script>";
      
  } 
  include("includes/footer.php");
?>