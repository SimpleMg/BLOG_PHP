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
    <title>Register</title>
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
                $password = $format->validation(password_hash($_POST["password"], PASSWORD_BCRYPT));

                $username = mysqli_real_escape_string($db->link, $username);
                $password = mysqli_real_escape_string($db->link, $password);
                //Récupérer les données de la table user
                if(empty($username) || empty($password))
                {
                    echo "merci de rentrer des informations";
                }
                else
                {
                    $queryU = "INSERT INTO user(username, passwordH) VALUES('$username','$password')";
                    $request = $db->insert($queryU);
                    if($request == TRUE)
                    {
                        echo "<script>alert(\"SUCCESS inscription réaliser\")</script>";
                        header("location: login_user.php");
                    }
                    else
                    {
                        echo "<script>alert(\"ERREUR  inscription non réaliser\")</script>";
                    }
                }
            }
            ?>
            <form action="" method="post">
                <h1>Inscription User</h1>
                <div>
                    <input type="text" placeholder="Identifiant" required="" name="username" />
                </div>
                <div>
                    <input type="password" placeholder="Mot de passe" required="" name="password" />
                </div>
                <div>
                    <input type="submit" value="S'inscrire" />
                </div>
            </form><!-- form -->
            <div class="button">
            </div><!-- button -->
       </section><!-- content -->
    </div><!-- container -->
</body>

</html>