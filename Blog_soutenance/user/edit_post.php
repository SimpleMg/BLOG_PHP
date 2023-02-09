<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<?php
// Si la méthode de requête est GET
$id_post = $_GET["edit_postid"];
?>
<?php
$db = new Database();
$format = new Format();
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Ajouter un nouveau post</h2>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Si la méthode de requête est POST
            // Alors
            //     Récupérer la valeur de title
            $title = $format->validation($_POST["title"]);
            $title = mysqli_real_escape_string($db->link,$title);
            //     Récupérer la valeur de category_id
            $category_id = strstr($_POST["category_id"], '-', true); 
            //$category_id = mysqli_real_escape_string($db->link,$category_id);
            //     Récupérer la valeur de author
            $author = $format->validation($_POST["author"]);
            $author = mysqli_real_escape_string($db->link,$author);
            //     Récupérer la valeur de tags
            $tags = $format->validation($_POST["tags"]);
            $tags = mysqli_real_escape_string($db->link,$tags);
            //     Récupérer la valeur de body
            $body = $format->validation($_POST["body"]);
            $body = mysqli_real_escape_string($db->link,$body);
            // recup image
            $fichier = basename($_FILES['image']['name']);
            $user_id = $_SESSION["userid"];
            if(!empty($title))
            {
                $queryU = "UPDATE post SET title='$title' WHERE id='$id_post' AND user_id='$user_id' ";
                $request = $db->update($queryU);
            }
            if(!empty($category_id))
            {
                $queryU = "UPDATE post SET  category_id='$category_id' WHERE id='$id_post' AND user_id='$user_id'";
                $request = $db->update($queryU);
            }
            if(!empty($author))
            {
                $queryU = "UPDATE post SET author='$author' WHERE id='$id_post' AND user_id='$user_id'";
                $request = $db->update($queryU);
            }
            if(!empty($tags))
            {
                $queryU = "UPDATE post SET tags='$tags' WHERE id='$id_post' AND user_id='$user_id'";
                $request = $db->update($queryU);
            }
            if(!empty($body))
            {
                $queryU = "UPDATE post SET body='$body' WHERE id='$id_post' AND user_id='$user_id'";
                $request = $db->update($queryU);
            }
            if(!empty($fichier))
            {
                $dossier = 'uploads/';
                $taille_maxi = 100000;
                $taille = filesize($_FILES['image']['tmp_name']);
                $extensions = array('.png', '.gif', '.jpg', '.jpeg');
                $extension = strrchr($_FILES['image']['name'], '.'); 
                //Début des vérifications de sécurité...
                if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                {
                    $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
                }
                if($taille>$taille_maxi)
                {
                    $erreur = 'Le fichier est trop gros...';
                }
                if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
                {
                    //On formate le nom du fichier ici...
                    $fichier = strtr($fichier, 
                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                    $strQue = $dossier . $fichier;
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $strQue)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                    {
                        echo "ok";
                        $user_id = $_SESSION["userid"];
                        $queryU = "UPDATE post SET image='$strQue' WHERE id='$id_post' AND user_id='$user_id'";
                        
                        $request = $db->update($queryU);
                    }
                    else //Sinon (la fonction renvoie FALSE).
                    {
                        echo "<script>alert(\"ERREUR donnée non envoyer\")</script>";
                    }
                }
                else
                {
                    echo $erreur;
                }
            }
        }

        ?>
        <div class="block">
            <?php
            // Récupérer le post de la table post
            // Tant que le post est récupéré
            //     Afficher les valeurs de title, category_id, author, tags, body et image dans les champs correspondants
            $user_id = $_SESSION["userid"];
            $requete = $db->select("SELECT * FROM post WHERE user_id='$user_id'");
            if($requete)
            {
                $value = mysqli_fetch_array($requete);
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="form">

                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="title" placeholder="<?php if($requete) if(!empty($value["title"]) > 0) echo $value["title"]?>" class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Categories</label>
                        </td>
                        <td>
                        <select id="select" name="category_id">
                                <option>Select Category </option>
                                <?php
                                // Récupérer les catégories de la table category
                                // Tant que les catégories sont récupérées
                                //     Afficher les catégories dans la liste déroulante
                                             // Récupérer toutes les catégories de la table category
                                    $queryU = "SELECT * FROM category";
                                    $request = $db->select($queryU);
                                    if($request)
                                    {
                                    foreach($request as $element){
                                    ?>
                                        <option><?php echo $element["category_id"] . ' - ' . $element["name"]?></option>
                                <?php

                                    }
                                }
                                    // Tant que la catégorie est récupérée
                                    //     Afficher la catégorie
                                ?>
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Télécharger une image</label>
                        </td>
                        <td>
                            <img src="<?php if($requete) if(!empty($value["image"]) > 0) echo $value["image"]?>" height="60px" width="100px" alt="">
                            <input type="file" name="image" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nom de l'auteur</label>
                        </td>
                        <td>
                            <input type="text" name="author" placeholder="<?php if($requete) if(!empty($value["author"]) > 0) echo $value["author"] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Tags</label>
                        </td>
                        <td>
                            <input type="text" name="tags" placeholder="<?php if($requete) if(!empty($value["tags"]) > 0) echo $value["tags"] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Contenu</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="body"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Sauvegarder" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<?php
// Inclure le fichier footer.php
include("includes/footer.php");
?>