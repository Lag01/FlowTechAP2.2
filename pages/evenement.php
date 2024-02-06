<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: ../pages/connexion.php");
    exit();
} else {
};

<
!DOCTYPE html >
<html lang = "fr" >

<head >
    <meta charset = "utf-8" />
    <meta name = "viewport" content = "width=device-width, initial-scale=1" />
    <title > Évènements - FlowTech</title >
    <meta name = "description" content = "FlowTech, surement les meilleurs PC du marché!" />
    <link rel = "icon" type = "image/x-icon" href = "../img/logos/logo-min-rounded.png" />
    <!--CSS CUSTOM + BOOTSTRAP-- >
    <link href = "/css/custom.css" rel = "stylesheet" />
    <!--BOOTSTRAP ICONS-- >
    <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
</head >
<body >
<section class="container" >
    <div class="dropdown" >
        <button class="btn btn-flowtech dropdown-toggle" type = "button" data - bs - toggle = "dropdown"
                aria - expanded = "false" >
                    Inscrivez - vous aux évènements
</button >
        <ul class="dropdown-menu" >
            <li ><a class="dropdown-item" href = "#" > Action</a ></li >
            <li ><a class="dropdown-item" href = "#" > Another action </a ></li >
            <li ><a class="dropdown-item" href = "#" > Something else here </a ></li >
        </ul >
    </div >
</section >
<script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script >

</body >
</html >