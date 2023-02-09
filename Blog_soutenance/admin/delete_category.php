
<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<?php
  $name = $_GET["name"];
  $catid = $_GET["catid"];
  //requête de suppression
  $requete = $db->delete("DELETE FROM category WHERE category_id='$catid' AND name = '$name'");
  if($requete)
  {
      echo "<script>alert(\"SUCCESS : categorie supprimer\")</script>";
  } else {
      //execute requete sql insert into
      echo "<script>alert(\"FAIL : categorie non supprimer\")</script>";
      
  } 
  include("includes/footer.php");
?>