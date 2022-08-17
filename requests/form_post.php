/* Page: contact.php */
<?php
//call function
require dirname(__DIR__) . '/functions.php';



//recipient's email address
$yourMail="le.corre.gwen.hael@dev-events.fr";
$email = strtolower(trim($_POST['email']));

if(empty($email)) {
    echo "Le champ mail est vide";
} else {
    //filter_var — Filters a variable with a specified filter
    //regular expressions mail
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "L'adresse mail entrée est incorrecte";
    }else{

        //we check that the subject field is correctly filled in
        if(empty($_POST['subject'])) {
            echo "Le champ sujet est vide";
        }else{

            //we check that the message field is not empty
            if(empty($_POST['message'])) {
                echo "Le champ message est vide";
            }elseif(strlen($_POST['message']) <60){
                    echo "Veuillez saisir un minimum de 60 caractères";

            }else{

                //everything is correctly filled in, we send the email
                //we fill in the headers of the PHP mail function
                $heading = "MIME-Version: 1.0\r\n";
                $heading .= "Content-type: text/html; charset=UTF-8\r\n";
                $heading .= "From: BuffyProject <".$_POST['email'].">\r\n";
                $heading .= "Reply-To: BuffyProject <".$_POST['email'].">\r\n";
                //on prépare les champs:
                $mail= $email;
                $topic= $_POST['subject'];//This encoding (base64_encode) is made to allow binary information to be manipulated by systems that do not handle 8 bits correctly (=?UTF-8?B? is a standard in order to correctly transmit the characters of the string)
                $message=htmlentities($_POST['message'],ENT_QUOTES,"UTF-8");//htmlentities() converts all accents to HTML entities, ENT_QUOTES + Converts double quotes and single quotes to HTML entities
                $sendMail = mb_send_mail($yourMail,$topic,nl2br($message),$heading); //the nl2br function keeps line breaks and the base64_encode function keeps accents in the title
                //we send the email
                if($sendMail){
                    echo "<p class='msg_success'>Le mail a été envoyé avec succès !</p>";
                } else {
                    echo "<p class='msg_error'>Une erreur est survenue, le mail n'a pas été envoyé veuillez réessayer plus tard...</p>";
                }
            }
        }
    }
}