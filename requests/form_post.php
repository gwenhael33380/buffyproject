<?php
//require dirname(__DIR__) . '/functions.php';
//
//
//
//
///* Page: contact.php */
////mettez ici votre adresse mail
//$votreAdresseMail="le.corre.gwen.hael@dev-events.fr";
//// si le bouton "Envoyer" est cliqué
//
//if(empty($_POST['email'])) {
//    echo "Le champ mail est vide";
//} else {
//    //regular expressions mail
//    if(!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,}$#i",$_POST['email'])){
//        echo "L'adresse mail entrée est incorrecte";
//    }else{
//        //on vérifie que le champ sujet est correctement rempli
//        if(empty($_POST['subject'])) {
//            echo "Le champ sujet est vide";
//        }else{
//            //on vérifie que le champ message n'est pas vide
//            if(empty($_POST['message'])) {
//                echo "Le champ message est vide";
//            }elseif(strlen($_POST['message']) <60){
//                    echo "Veuillez saisir un minimum de 60 caractères";
//
//            }else{
//                //tout est correctement renseigné, on envoi le mail
//                //on renseigne les entêtes de la fonction mail de PHP
//                $entetes = "MIME-Version: 1.0\r\n";
//                $entetes .= "Content-type: text/html; charset=UTF-8\r\n";
//                $entetes .= "From: Nom de votre site <".$_POST['email'].">\r\n";//de préférence une adresse avec le même domaine de là où, vous utilisez ce code, cela permet un envoie quasi certain jusqu'au destinataire
//                $entetes .= "Reply-To: Nom de votre site <".$_POST['email'].">\r\n";
//                //on prépare les champs:
//                $mail=$_POST['email'];
//                $sujet='=?UTF-8?B?'.base64_encode($_POST['subject']).'?=';//Cet encodage (base64_encode) est fait pour permettre aux informations binaires d'être manipulées par les systèmes qui ne gèrent pas correctement les 8 bits (=?UTF-8?B? est une norme afin de transmettre correctement les caractères de la chaine)
//                $message=htmlentities($_POST['message'],ENT_QUOTES,"UTF-8");//htmlentities() converti tous les accents en entités HTML, ENT_QUOTES Convertit en + les guillemets doubles et les guillemets simples, en entités HTML
//                //enfin, on envoi le mail
//                if(mail($votreAdresseMail,$sujet,nl2br($message),$entetes)){//la fonction nl2br permet de conserver les sauts de ligne et la fonction base64_encode de conserver les accents dans le titre
//                    echo "Le mail à été envoyé avec succès!";
//                } else {
//                    echo "Une erreur est survenue, le mail n'a pas été envoyé";
//                }
//            }
//        }
//    }
//}