<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<style>
    .left {
        float: left;
        width: 60%;
    }

    .right {
        float: left;
        width: 40%;
    }

    .right img {
        height: 140px;
        width: 150px;
    }
</style>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Mettre à jour le titre et la description du site</h2>
        <!--            For Update website Title & Logo-->
        <?php
        // Si la méthode de requête est POST
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Alors
            //     Récupérer la valeur de title
            $title = $format->validation($_POST["title"]);
            $title = mysqli_real_escape_string($db->link,$title);
            //     Récupérer la valeur de logo
            $fichier = basename($_FILES['logo']['name']);
            if(empty($title))
            {
            //     Si title est vide
            //         Alors
            //             Afficher un message d'erreur
                        echo "<script>alert(\"Rien rentrer pour titre\")</script>";

            }
            else if(empty($fichier))
            {
                $queryU = "UPDATE title SET title='$title'";
                $request = $db->update($queryU);
                if($request == TRUE)
                {
                    echo "<script>alert(\"SUCCESS donnée envoyer\")</script>";
                }
                else
                {
                    echo "<script>alert(\"ERREUR donnée non envoyer\")</script>";
                }
            }
            else
            {
                $dossier = 'uploads/';
                $taille_maxi = 100000;
                $taille = filesize($_FILES['logo']['tmp_name']);
                $extensions = array('.png', '.gif', '.jpg', '.jpeg');
                $extension = strrchr($_FILES['logo']['name'], '.'); 
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
                    if(move_uploaded_file($_FILES['logo']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                    {
                        $strQue = $dossier . $fichier;
                        $queryU = "UPDATE title SET logo='$strQue', title='$title'";
                        $request = $db->update($queryU);
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


        <!--               For show blog title  & logo from databa.se-->
        <?php
        // Récupérer les données de la table title_slogan
        $requete = $db->select("SELECT title, logo FROM title");
        if($requete)
        {
            $value = mysqli_fetch_array($requete);
        }
        // Tant que les données sont récupérées
        //     Afficher les données
        ?>
        <div class="block sloginblock">
            <div class="left">
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="form">
                        <tr>
                            <td>
                                <label>Titre du site Web</label>
                            </td>
                            <td>
                                <input type="text" placeholder="<?php if($requete) if(!empty($value["title"]) > 0)  echo $value["title"]?>" name="title" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Télécharger le logo</label>
                            </td>
                            <td>
                                <input type="file" name="logo" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input type="submit" name="submit" Value="Modifier" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="right">
                <img src="<?php if($requete) if(!empty($value["logo"]) > 0) echo $value["logo"]?>" alt="logo">
            </div>
        </div>
    </div>
</div>
<div class="clear">
</div>
</div>
<?php
// Inclure le fichier footer.php
include("includes/footer.php");
?>