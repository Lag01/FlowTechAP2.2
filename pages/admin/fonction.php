<?php

// Fonction de connexion à la BD 
function connect_bd($nomBd)
{
    $nomBd = 'nc231_flowtech';

    $nomServeur = 'nc231.myd.infomaniak.com';
    //nom du seveur
    $login = 'nc231_flowtech';
    //login de l'utilisateur
    $passWd = "Flowtech123";
    // mot de passe
    try {
        // Connexion à la BD et définition du jeu de caractères UTF-8
        $cnx = new PDO("mysql:host=$nomServeur; dbname=$nomBd", $login, $passWd);

        // PDO génére une erreur fatale si un problème survient. 
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Jeu de caractères
        $cnx->exec("SET CHARACTER SET utf8");

        echo "connecté !";
        return $cnx;

    } catch (PDOException $e) {

        print "Erreur!" . $e->getMessage() . "<br/>";
        die();
        return 0;
    }
}

// Fonction de deconnexion de la BD 
function deconnect_bd($nomBd)
{
    $nomBd = null;
}