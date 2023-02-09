
<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php"; ?>


<div class="grid_10">
    <div class="box round first grid">
        <h2>Voir les messages</h2>
        <?php
        /*
        if($requete)
        {
            $value = mysqli_fetch_array($requete);
        }
        */
        ?>
    <div class="block">
                    <?php
                    // Récupérer toutes les catégories de la table category
                    $requete = $db->select("SELECT id, name, subject, email, message FROM contact");
                    if($requete)
                    {
                        echo ' <table class="data display datatable" id="example">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Object</th>
                                    <th>Message</th>
                                </tr>
                            </thead>';
                        foreach($requete as $element){
                            echo '
                            <tbody>
                                <tr class="odd gradeX">
                                    <td>' . $element['id'] . '</td>
                                    <td>' . $element['name'] . '</td>
                                    <td>' . $element['subject']  . '</td>
                                    <td>' . $element['email']  . '</td>
                                    <td>' . $element['message']  . '</td>
                                    <td>
                                    <a onclick="return confirm("Êtes-vous sûr de vouloir supprimer?")" href="delete_email.php?id='.$element['id'].'">Supprimer</a>
                                    </td>
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
        -->
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


<?php include "includes/footer.php"; ?>

