<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<div class="grid_10">

    <div class="box round first grid">
        <h2>Ajouter une nouvelle catégorie</h2>
        <div class="block copyblock">
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                // Si la méthode de requête est POST
                // Alors
                //     Récupérer la valeur de name
                $name = $format->validation($_POST["name"]);
                $name = mysqli_real_escape_string($db->link,$name);
                //     Si name est vide
                if(empty($name))
                {
                    //         Alors
                    //             Afficher un message d'erreur
                    echo "donnée non envoyer car rien rentrer";
                }
                else
                {
                    //         Sinon
                    //             Insérer la catégorie dans la table category
                    $queryU = "INSERT INTO category(name) VALUES ('$name')";
                    $request = $db->insert($queryU);
                    if($request == TRUE)
                    {
                        echo "donnée envoye";
                    }
                    else
                    {
                        echo "donnée non envoyer";
                    }
                }
            }
            ?>
            <form method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="name" placeholder="Entrez le nom de la catégorie..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" Value="Sauvegarder" />
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