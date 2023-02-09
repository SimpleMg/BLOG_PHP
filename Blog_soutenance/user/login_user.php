<?php
// Inclure le fichier Session.php depuis le dossier classes
include("../classes/Session.php");
// Inclure la session et le checkLogin
Session::checkLogin();
?>
<?php
// Inclure le fichier config.php depuis le dossier config
include("../config/config.php");
// Inclure le fichier Database.php depuis le dossier db
include("../db/Database.php");
// Inclure le fichier format.php depuis le dossier classes
include("../classes/format.php");

?>

<?php
$db = new Database();
$format = new Format();
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>

<body>
    <div class="container">
        <section id="content">
            <?php
            // Si la méthode de requête est POST
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
            // Alors
            //     Récupérer la valeur de username
                $username = $format->validation($_POST["username"]);
                //Récupérer la valeur de password
                $password = $format->validation($_POST["password"]);

                $username = mysqli_real_escape_string($db->link, $username);
                $password = mysqli_real_escape_string($db->link, $password);
                //Récupérer les données de la table user
                $requete = $db->select("SELECT * FROM user WHERE username = '$username'");
                if($requete)
                {
                $value = mysqli_fetch_array($requete);
                if (password_verify($password, $value["passwordH"])) {
                    $password = $value["passwordH"];
                    $requete = $db->select("SELECT * FROM user WHERE username = '$username' AND passwordH ='$password'");
                    //Tant que les données sont récupérées
                    if($requete != FALSE)
                    {
                    //  Récupérer la valeur de username et password
                    $value = mysqli_fetch_array($requete);
                    //  Si username et password sont égaux aux valeurs récupérées
                    $row = mysqli_num_rows($requete);
                        if($row > 0)
                        {
                         //Définir la session login
                            Session::set("login", true);
                            Session::set("username", $value['username']);
                            Session::set("userid", $value['user_id']);
                                    header('location: index.php');


                        }
                        else
                        {
                                echo "Pas de resultat";
                        }
                    }
                    else
                    {
                            echo "erreur password ou username incorrect";
                    }
                }
                else
                {
                    echo "mot de passe incorrect";
                }
            }
        }
            ?>
            <form action="" method="post">
                <h1>Connexion User</h1>
                <div>
                    <input type="text" placeholder="Identifiant" required="" name="username" />
                </div>
                <div>
                    <input type="password" placeholder="Mot de passe" required="" name="password" />
                </div>
                <div>
                    <input type="submit" value="Se connecter" />
                </div>
            </form><!-- form -->
            <form action="register.php">
            <div>
                    <input type="submit" value="S'inscrire" />
                </div>
            </form>
       </section><!-- content -->
    </div><!-- container -->
</body>

</html>