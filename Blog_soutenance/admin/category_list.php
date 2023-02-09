<?php
// Inclure le fichier header.php
include("includes/header.php");
// Inclure le fichier sidebar.php
include("includes/sidebar.php");
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Category List</h2>
        <div class="block">
                    <?php
                    // Récupérer toutes les catégories de la table category
                    $requete = $db->select('SELECT * FROM category ORDER BY category_id DESC');
                    if($requete)
                    {
                    echo ' <table class="data display datatable" id="example">
                        <thead>
                            <tr>
                                <th>N. De série</th>
                                <th>Nom Catégorie</th>
                                <th>Action</th>
                            </tr>
                        </thead>';
                    foreach($requete as $element){
                        echo '
                        <tbody>
                            <tr class="odd gradeX">
                                <td>' . $element['category_id'] . '</td>
                                <td>' . $element['name']  . '</td>
                                <td><a href="edit_category.php?catid='.$element['category_id'].'&' . 'name='.$element['name'].'">Modifier</a>
                                || <a onclick="return confirm("Êtes-vous sûr de vouloir supprimer?")" href="delete_category.php?catid='.$element['category_id'].'&' . 'name='.$element['name'].'">Supprimer</a></td>
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