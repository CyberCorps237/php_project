<?php
    session_start();
    $message_email = '';
    require_once('C:\xampp12\htdocs\ProjetGit\layout\connect.php');
    //require_once("headerset.php");
    if(isset($_POST['envoi'])){
        $EMAIL = $_POST['EMAIL'];
        $TOKEN = bin2hex(random_bytes(16));
        if(empty($EMAIL)){
            $message_email="EMAIL INVALIDE";
        }
        $request= 'SELECT * FROM PERSONNELS P JOIN SECRETAIRE SE ON P.ID_COMPTE=SE.ID_COMPTE WHERE P.EMAIL=SE.EMAIL=?';
        $pdostmt = $db->prepare($request);
        $pdostmt->execute(array($EMAIL));
        $resultat=$pdostmt->fetchAll(PDO::FETCH_ASSOC);//on récupère les données de la table secretaire
        if($resultat){ 
            $_SESSION['EMAIL'] = $EMAIL;
            $_SESSION['TOKEN'] =$TOKEN;

        }else {
            $request= 'SELECT * FROM PERSONNELS P JOIN ADMINISTRATEUR AD ON P.ID_COMPTE=AD.ID_COMPTE WHERE P.EMAIL=AD.EMAIL=?';
            $pdostmt = $db->prepare($request);
            $pdostmt->execute(array($EMAIL));
            $resultat=$pdostmt->fetchAll(PDO::FETCH_ASSOC);//on récupère les données de la table administrateur
            
            $_SESSION['EMAIL'] = $EMAIL;
            $_SESSION['TOKEN'] =$TOKEN;
        }
        //session_destroy();
        function sendmail($addresse,$code){
            include_once('mailer.php');
        }
        sendmail($EMAIL, $TOKEN);
    }
?>
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css\bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
     crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


</head>
<div class="row mt-5 py-5  justify-content-center align-items-center w-100">
        <form action="" method="post" class="w-50 bg-light mt-3 py-4">
        <div class="col-1 py-2 ms-5 mt-1  fixed-top mt-5 py-5">
            <button type="button"  class="text-warning float-start bg-success btn " onclick="history.back()"><i class="bi bi-arrow-left-short icon-link-hover"></i></button>
        </div>

            <div class="row mt-2 py-2">
                <h1 class="text-center text-info text-uppercase">renitialiser le mot de passe</h1>
            </div>
            <div class="mt-3 py-2">
                <label for="EMAIL" class="form-label ">EMAIL </label>
                <input type="email" name="EMAIL" id="EMAIL" class="form-control" placeholder="Entrer votre pour reinitialiser votre mot de passe" >
                <input type="hidden" name="ID_TYPE_COMPTE" id="ID_TYPE_COMPTE" class="form-control " value ="<?= $ID_TYPE_COMPTE ?>">
                <p class="text-center text-danger"><?=  $message_email ?></p>
            </div>
            <div class="mt-3 py-3 d-flex justify-content-center  justify-content-center align-items-center w-100">
                <input type="submit" value="Envoyer" class="btn btn-success w-25" name="envoi">
            </div>

        </form>
    </div>
    
</body>
</html>