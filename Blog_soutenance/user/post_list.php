﻿<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block">
            <?php

                    // Récupérer toutes les catégories de la table category
                    $user_id = $_SESSION["userid"];
                    $requete = $db->select("SELECT * FROM post WHERE user_id='$user_id'");
                    if($requete)
                    {
                    echo ' <table class="data display datatable" id="example">
                        <thead>
                            <tr>
                            <th width="5%">SL No</th>
                            <th width="13%">Titre du post</th>
                            <th width="25%">Description</th>
                            <th width="10%">Categorie</th>
                            <th width="10%">Image</th>
                            <th width="10%">Autheur</th>
                            <th width="5%">Tags</th>
                            <th width="10%">Date</th>
                            <th width="12%"> Action</th>
                            </tr>
                        </thead>';
                    foreach($requete as $element){
                        echo '
                        <tbody>
                        <tr class="odd gradeX">
                        <td>' . $element["id"] . '</td>
                        <td>' . $element["title"] . '</td>
                        <td>' . $element["body"] . '</td>
                        <td>' . $element["category_id"] . '</td>
                        <td><img src="' . $element["image"] . '" height="40px" width="80px" alt=""></td>
                        <td>' . $element["author"] . '</td>
                        <td>' . $element["tags"] . '</td>
                        <td> ' . $element["date"] . ' </td>
                        <td><a href="edit_post.php?edit_postid=' . $element["id"].'">Modifier</a>
                            || <a onclick="return confirm("Etes vous sur de vouloir supprimer ?")" href="delete_post.php?del_postid='. $element["id"].'">Supprimer</a></td>
                    </tr>
                        </tbody>
                    ';
                    }

                    echo '

                    </table>';      
                    // Tant que la catégorie est récupérée
                    //     Afficher la catégorie
                }
                    ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        setupLeftMenu();
        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php
// Inclure le fichier footer.php
include("includes/footer.php");
?>