<?php include "includes/header.php"; ?>
<?php include "config/config.php"; ?>
<?php
$requete = $db->select("SELECT email, passwordH FROM email");
if($requete)
{
    $value = mysqli_fetch_array($requete);
}
?>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>
<?php
//            Contact Form Validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $format->validation($_POST['name']);
    $email = $format->validation($_POST['email']);
    $subject = $format->validation($_POST['subject']);
    $message = $format->validation($_POST['message']);
    try {
        $mail = new PHPMailer(true);
    } catch (Exception $e) {
        echo "Mailer Error: ".$mail->ErrorInfo;
    }
    $mail->isSMTP();
    $mail->Host = 'smtp-simplemg.alwaysdata.net';
    $mail->SMTPAuth = true;
    $mail->Username = $value["email"];
    $mail->Password = $value["passwordH"];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom($email);



    $name = mysqli_real_escape_string($db->link, $name);
    $email = mysqli_real_escape_string($db->link, $email);
    $subject = mysqli_real_escape_string($db->link, $subject);
    $message = mysqli_real_escape_string($db->link, $message);
    
    $mail->addAddress($value["email"]);     
    $mail->isHTML(true);
    $mail->Subject= $subject;
    $mail->Body=$message;
    if($mail->send())
    {
        echo '<script>alert("mail envoyer")</script>';
    }
    else
    {
        echo '<script>alert("erreur")</script>';

    }
    $error = '';
    if (empty($name)) {
        $error = 'Votre nom doit être rempli';
    } elseif (empty($email)) {
        $error = "Votre adresse email doit être remplie";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = " Adresse email invalide";
    } elseif (empty($subject)) {
        $error = "Votre objet doit être rempli";
    } elseif (empty($message)) {
        $error = "Votre message doit être rempli";
    } else {  /* After validation, message sent into database*/
        $query = "INSERT INTO contact(name, email,subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        $send_message = $db->insert($query);
        if ($send_message) {
            $msg = " Votre message a été envoyé avec succès";
        } else {
            $error = "Votre message n'a pas été envoyé";
        }
    }
}
?>


<!--    Page Banner Start
==================================================-->
<section class="banner background9 overlay_three full_row">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="banner_text text-center">
                    <h1 class="page_banner_title color_white text-uppercase">Blog</h1>
                    <div class="breadcrumbs m-auto d-inline-block">
                        <ul>
                            <li class="hover_gray"><a href="index.php">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--    Page Banner End
==================================================-->

<!--	Start Contact
    ===================================================-->
<section id="contact" class="py_80 full_row bg_white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="section_title_1 text-center mx-auto pb_60 wow animated slideInUp">
                    <h2 class="title text-uppercase"><span class="line_double mx-auto color_default">contact</span>Entrez en contact</h2>
                    <span class="sub_title"></span>
                    <?php
                    //                        Show validation message
                    if (isset($error)) {
                        echo "<span style=\"color: red\"> $error</span>";
                    }
                    if (isset($msg)) {
                        echo "<span style=\"color: green\"> $msg</span>";
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md col-lg">
                        <form class="form contact_message wow animated fadeInRight" action="" method="post">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="Votre nom" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="email" name="email" placeholder="Email" />
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="subject" placeholder="Objet" />
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" rows="7" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <input class="btn btn-default" value="Envoyer" type="submit" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--	End Contact
===================================================-->

<?php include "includes/footer.php"; ?>