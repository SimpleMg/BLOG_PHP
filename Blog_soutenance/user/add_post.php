<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<div class="grid_10">

    <div class="box round first grid">
        <h2>Ajouter un nouveau post</h2>
        <?php
        // Si la méthode de requête est POST
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        // Alors
        //     Récupérer la valeur de title
        $title = $format->validation($_POST["title"]);
        $title = mysqli_real_escape_string($db->link,$title);
        //     Récupérer la valeur de category_id
        $category_id = strstr($_POST["category_id"], '-', true); 
        //     Récupérer la valeur de author
        $author = $format->validation($_POST["author"]);
        $author = mysqli_real_escape_string($db->link,$author);
        //     Récupérer la valeur de tags
        $tags = $format->validation($_POST["tags"]);
        $tags = mysqli_real_escape_string($db->link,$tags);
        //     Récupérer la valeur de body
        $body = $format->validation($_POST["body"]);
        $body = mysqli_real_escape_string($db->link,$body);
        //     Récupérer la valeur de image
        $fichier = basename($_FILES['image']['name']);
        if(empty($title))
        {
        //     Si title est vide
        //         Alors
        //             Afficher un message d'erreur
        echo "titre vide erreur";

        }
        else
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
                    $user_id = $_SESSION["userid"];
                    $strQue = $dossier . $fichier;
                    $queryU = "INSERT INTO post(category_id, title, body, image, author, tags, user_id) VALUES($category_id,'$title','$body','$strQue','$author','$tags',$user_id)";
                    $request = $db->insert($queryU);
                    if($request == TRUE)
                    {
                        echo "<script>alert(\"SUCCESS donnée envoyer\")</script>";
                    }
                    else
                    {
                        echo "<script>alert(\"ERREUR donnée non envoyer\")</script>";
                    }
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
            <form action="" method="post" enctype="multipart/form-data">
                <table class="form">

                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="title" placeholder="Entrez le titre du post" class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Category</label>
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
                                        echo '
                                        <option>' . $element["category_id"] . ' - ' . $element["name"] . '</option>

                                    ';
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
                            <label>Télecharger une image</label>
                        </td>
                        <td>
                            <input type="file" name="image" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nom de l'auteur</label>
                        </td>
                        <td>
                            <input type="text" name="author" placeholder="Entrez le nom de l'auteur." />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Tags</label>
                        </td>
                        <td>
                            <input type="text" name="tags" placeholder="Entrez le tag ici ..." />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Content</label>
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
<?php
// Inclure le fichier footer.php
include("includes/footer.php");
?>