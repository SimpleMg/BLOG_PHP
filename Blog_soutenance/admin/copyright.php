<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Mettre à jour le texte du droit d'auteur</h2>
        <?php
        // Si la méthode de requête est POST
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        // Alors
        //     Récupérer la valeur de copyright
        $copyright = $format->validation($_POST["copyright"]);
        $copyright = mysqli_real_escape_string($db->link,$copyright);
        if(empty($copyright))
        {
            echo "probleme d'envoie";
        }
        else
        {
            $queryU = "UPDATE footer SET copyright='$copyright'";
            $request = $db->update($queryU);
            if($request == TRUE)
            {
                echo "donnée envoye";
            }
            else
            {
                echo "ERREUR donnée non envoyer";
            }
        }
        }
        ?>

        <div class="block copyblock">
            <!--    For show social link from database-->
            <?php
            // Récupérer le copyright de la table footer
            $requete = $db->select("SELECT copyright FROM footer");
            if($requete)
            {
                $value = mysqli_fetch_array($requete);
            }
            // Tant que le copyright est récupéré
            //     Afficher le copyright
            ?>
            <form action="" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" placeholder="<?php if($requete) if(!empty($value["copyright"])) echo $value["copyright"]?>" name="copyright" class="large" />
                        </td>
                    </tr>

                    <tr>
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