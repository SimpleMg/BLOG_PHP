<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<div class="grid_10">

    <div class="box round first grid">
        <h2>Mettre à jour les médias sociaux</h2>
        <!--   For update social media -->
        <?php
        // Si la méthode de requête est POST
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        // Alors
        //     Récupérer la valeur de facebook
        $facebook = $format->validation($_POST["facebook"]);
        $facebook = mysqli_real_escape_string($db->link,$facebook);
        //     Récupérer la valeur de github
        $github = $format->validation($_POST["github"]);
        $github = mysqli_real_escape_string($db->link,$github);
        //     Récupérer la valeur de skype
        $skype = $format->validation($_POST["skype"]);
        $skype = mysqli_real_escape_string($db->link,$skype);
        //     Récupérer la valeur de linkedin
        $linkedin = $format->validation($_POST["linkedin"]);
        $linkedin = mysqli_real_escape_string($db->link,$linkedin);
        //     Récupérer la valeur de google
        $google = $format->validation($_POST["google"]);
        $google = mysqli_real_escape_string($db->link,$google);
        //     Si facebook, github, skype, linkedin ou google est vide
        if(strlen($facebook) == 0 && strlen($github) == 0 && strlen($skype) == 0 && strlen($linkedin) == 0 && strlen($google) == 0)
        {
            echo "erreur donnee non envoyer car rien rentrer";
        }
        else
        {
            if(!empty($facebook))
            {
                $queryU = "UPDATE social SET facebook='$facebook'";
                $request = $db->update($queryU);
            }
            if(!empty($github))
            {
                $queryU = "UPDATE social SET  github='$github'";
                $request = $db->update($queryU);
            }
            if(!empty($skype))
            {
                    $queryU = "UPDATE social SET skype='$skype'";
                    $request = $db->update($queryU);
            }
            if(!empty($linkedin))
            {
                        $queryU = "UPDATE social SET linkedin='$linkedin'";
                        $request = $db->update($queryU);
            }
            if(!empty($google))
            {
                            $queryU = "UPDATE social SET google='$google'";
                            $request = $db->update($queryU);
            }
            if($request == TRUE)
            {
                echo "donnée envoye";
            }
        }
        }
        

        ?>

        <div class="block">
            <!--     For show social link from database-->
            <?php
            // Récupérer les données de la table tbl_social
            // Tant que les données sont récupérées
            //     Afficher les données
            $queryU = "SELECT facebook, github, skype, linkedin,google FROM social";
            $request = $db->select($queryU);
            if($request)
            {
                $value = mysqli_fetch_array($request);
            }
            ?>
            <form action="" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <label>Facebook</label>
                        </td>
                        <td>
                            <input type="text" name="facebook" placeholder="<?php if($request && !empty($value["facebook"]) > 0) echo $value["facebook"]; ?>" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Github</label>
                        </td>
                        <td>
                            <input type="text" name="github" placeholder="<?php if($request && !empty($value["github"]) > 0) echo $value["github"]; ?>" class=" medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Skype</label>
                        </td>
                        <td>
                            <input type="text" name="skype" placeholder="<?php if($request && !empty($value["skype"]) > 0)  echo $value["skype"]; ?>" class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>LinkedIn</label>
                        </td>
                        <td>
                            <input type="text" name="linkedin" placeholder="<?php if($request && !empty($value["linkedin"]) > 0)  echo $value["linkedin"]; ?>" class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Google </label>
                        </td>
                        <td>
                            <input type="text" name="google" placeholder="<?php if($request && !empty($value["google"]) > 0)  echo $value["google"]; ?>" class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Modifier" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php
// Inclure le fichier footer.php
include("includes/footer.php");

?>