<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<?php
// Si la méthode de requête est GET
// Alors
//     Récupérer la valeur de catid
$catid = $_GET["catid"];
$name  = $_GET["name"];

if(empty($catid))
{
//     Si catid est vide
//         Alors
//             Rediriger vers category_list.php
header("location: category_list.php");
}

?>


<div class="grid_10">

    <div class="box round first grid">
        <h2>Update Category</h2>
        <div class="block copyblock">
            <!--                Category update query-->
            <?php
            
            // Si la méthode de requête est POST
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
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
                $queryU = "UPDATE category set name='$name' WHERE category_id='$catid'";
                $request = $db->update($queryU);
                if($request == TRUE)
                {
                    echo "donnée envoye";
                }
                else
                {
                    echo "donnée non envoyer";
                }
                //             Si la catégorie est insérée
                //                 Alors
                //                     Afficher un message de succès
                //                 Sinon
                //                     Afficher un message d'erreur
            }
        }   
            ?>
            <!--                Show selected Category -->
            <form method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="name" placeholder="<?php if(!empty($name)) echo "$name" ?>" class="medium" />
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