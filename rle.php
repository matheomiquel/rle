<?php 
    function encode_rle(string $str)
    {
        $compress; // Variable
        $modele = $str[0]; // Le premier caractère sera enregistré dans la variable modele
        $a = 0; // Variable

        if (!ctype_alpha($str) or strlen($str) == 0) //  Vérifie si la string envoyée est seulement composée de caractères alpha et également si elle n'est pas vide
            return ("$$$"); // Si vide alors on renvoie la string "$$$"
        for ($i = 0; $i < strlen($str);$i++) { // Boucle jusqu'à la fin de la taille de la string caractère par caractère
            if ($modele[0] == $str[$i]) // Si le caractère contenue dans modele est strictement égal à celui dans la string à l'index i
                $a++; // On incremente donc une variable nommée a
            else {      // sinon
                $compress .= $a . $str[$i -1]; // On concatène dans la variable compress la valeur de a puis on stocke le caractère;
                $a = 1; // Réinitialise la variable a
                $modele[0] = $str[$i]; // On modifie la valeur de modele avec la valeur contenue dans str à l'index i
            }
        } 
        $compress .= $a . $str[$i - 1]; // Concatène dans la variable compress la valeur de a puis stocke le caractère;
        return ($compress); // Retourne la variable compress
    }

    function decode_rle(string $str)
    {
        $a;  // Variable
        $string;  // Variable
        $number = 0;  // Variable

        if (!ctype_alnum($str) + strlen($str) == 0) // Vérifie si la string envoyée est seulement composée de caractères alphanumériques et également si elle n'est pas vide
            return "$$$"; // Si vide alors on renvoie la string "$$$"
        for($i = 0;$i < strlen($str) ;$i++) // Boucle jusqu'à le fin de la taille de la string caractère par caractère
            if(ctype_alpha($str[$i]) and !is_numeric($str[$i - 1]))  // Vérifie si c'est des chiffres qui précédent des lettres
                return ("$$$");// Si c'est le cas retourne "$$$"
        for ($i = 0;$i <= strlen($str); $i++) // Pour vérifier la taille de str
            if (is_numeric($str[$i]))   // Vérifie si les caracteres sont numériques
                $a .= $str[$i]; // Concatène le nombre dans la variable a
            else { // sinon
                for ($j = 0;$j < $a; $j++) // Pour la variable a
                    $string .= $str[$i]; // Concatène dans la string le caractère à l'index i
                $a = 0; // Réinitialise la valeur de la variable a
            }
        return ($string); // Retourne string
    }



    function encode_advanced_rle(string $path_to_encode, string $result_path)
    {
        $repet = 1;
        $nonrepet = 0;

        if (!file_exists($path_to_encode) or exif_imagetype($path_to_encode) != 6) // Vérifie si le fichier existe et si c'est bien un fichier bmp
            return "$$$"; // Sinon retourne "$$$"
        $output = file_get_contents($path_to_encode); // Récupère le contenu du fichier envoyé et l'affiche dans l'output
        for ($i = 0;$i < strlen($output);$i++) { // Pour chaque caractère dans l'output
            if ($output[$i] == $output[$i + 1]) {  // Vérifie si la string pour index i est strictement égale à string pour index i + 1 
                if ($repet < 255) // Si la variable repet est inférieure à 255
                    $repet++;   // Incrémentation de la variable repet
                else { // Sinon
                    $compression .=  chr($repet) . $output[$i]; // Concatène dans la variable compression
                    $repet = 1; // Réinitialise la variable repet a 1
                }
                if ($nonrepet != 0){ // Si la variable nonrepet est différente de 0 
                    $compression .=  chr(0) . chr($nonrepet) . $word; // Concatène chr(0) pour avoir la valeur 0 (et non l'ASCII qui vaut 48)
                    $word = ""; // Réinitialise la variable word
                }
                $nonrepet = 0; // Réinitialise la variable nonrepet à 0
            }
            else { // Sinon
                if ($repet > 1) // Vérifie la variable repet est supérieure a 1
                    $compression .=  chr($repet) . $output[$i]; // Concaténation
                else {
                    if ($nonrepet == 255) { // Si la variable nonrepet est strictement égale à la valeur 255
                        $compression .=  chr(0) . chr($nonrepet) . $word; // Concatène
                        $nonrepet = 0; // Réinitialise la variable nonrepet à 0
                        $word = ""; // Réinitialise la variable word
                    }
                    $word .= $output[$i]; // Concatène
                    $nonrepet++; // Incrémentation de la variable nonrepet
                }
                $repet = 1; // Réinitialise la variable repet a 1
            }
        }
        if($nonrepet != 0) // Si la variable nonrepet est différente de 0
            $compression .= chr(0) . chr($nonrepet) . $word; // Concatène
        file_put_contents($result_path, $compression); // On stocke le contenu de la variable compression dans le fichier qu'on a passé en argument
    }

    function decode_advanced_rle(string $path_to_uncode, string $result_path)
    {
        if (!file_exists($path_to_uncode)) // Vérifie si le fichier existe
            return ("$$$"); 
        $file = file_get_contents($path_to_uncode); // Stocke le contenu du fichier passé en argument dans la string 
        for ($i = 0;$i < strlen($file);$i++) { // Boucle
            if ($file[$i] == chr(0)) {    
                $i++; // Incrementation 
                $value = ord($file[$i]); // Stocke la valeur de file de i dans la variable $value
                for ($j = 0; $j < $value; $j++) { // Boucle tant que j est inferieur à  value
                    $i++; // Incrémentation de i
                    $decompress .= $file[$i]; // Concaténation
                }
            } else { // Sinon
                $compt = $file[$i]; // La variable compt est égale a file de i
                $i++; // Incrémentation
                for ($j = 0;$j < ord($compt) ;$j++) { 
                    $decompress .= $file[$i];  // Place les caractères
                }
            }
        }
        file_put_contents($result_path, $decompress); // On stocke le contenu de la variable decompression dans le fichier qu'on a passé en argument
    }

    function start($i){
        $result = 0;
<<<<<<< HEAD
        if($i == 0) // si c'est le premier tour alors affiche bienvenue
            echo ("Bienvenue\n");
        while ($result < 1 or $result > 4){
            echo ("Choisissez votre fonction?\n");
            $result = readline("1 pour encode basic\n2 pour decode Basic\n3 pour encode avenced\n4 pour the decode advanced :\n"); // on enregistre dans result ce que met l'utilisateur
            if ($result < 1 or $result > 4){ // si l'utilisateur n'a pas mis de valeur correct on lui dit et on lui redemande de choisir
                system("clear");
                echo ("la valeur rentrer n'est pas bonne !!!\n");
            }
        }  
        return $result; // on retourne result
    }

    function choice($result)
    {
        system("clear");
        if ($result < 3){ // appelle les fonction normal ou avancer en fonction de result
            normal($result);
        }
        else{
            advenced($result);
        }
    }

    function normal($result)
    {
        $function = ["encode_rle" , "decode_rle"]; // on crée un tableau avec les fonctions normales
        $first_arg = readline("mettez la chaine de caractere?\n"); // on enregistre l'input de l'utilisateur
        echo $function[$result - 1]($first_arg) . "\n"; // on print le retour de la fonction
    }

    function advenced($result)
    {
        $function = ["encode_advanced_rle", "decode_advanced_rle"]; // on crée un tableau avec les fonctions avancée
        $first_arg = readline("mettez la source?\n"); // on enregistre l'input de l'utilisateur
        $seconde_arg = readline("mettez la destination\n");// on enregistre l'input de l'utilisateur
        echo $function[$result - 3]($first_arg, $seconde_arg) . "\n"; // on print le retour de la fonction
    }

    $i = 0;
    while(1){ //boucle infinie
        system("clear");
        choice(start($i)); // on lance la fonction principal
        $i++;
        $continue = readline("pour arretez mettez n, toute autre chose pour continuer?\n"); // on demande a l'utilisateur si il veut continuer
        if (strpos($continue, "n") !== false) // si l'utilisateur veut stopper on break la boucle inf sinon on relance la fonction principale
=======
        if($i == 0) // Si c'est le premier tour affiche Bienvenue sur l'output
            echo ("Bienvenue\n");
        while ($result < 1 or $result > 4){
            echo ("Choisissez votre fonction?\n");
            $result = readline("1 pour encode basic\n2 pour decode Basic\n3 pour encode avenced\n4 pour the decode advanced :\n"); // Enregistre dans result ce que renseigne l'utilisateur
            if ($result < 1 or $result > 4){ // Si l'utilisateur rentre une valeur incorrecte on lui redemande de choisir
                system("clear");
                echo ("La valeur entree est incorrecte !!!\n"); // Ecrit sur l'output La valeur entree est incorrecte !!!
            }
        }  
        return $result; // Retourne result
    }

    function choice($result){
        if ($result < 3){ // Appelle la fonction normal ou avdvenced en fonction de result
            normal($result);
        }
        else{
            advenced($result);
        }
    }

    function normal($result)
    {
        $function = ["encode_rle" , "decode_rle"]; // Creation d'un tableau avec les fonctions normales
        $first_arg = readline("mettez la chaine de caractere?\n"); // Enregistre l'input de l'utilisateur
        echo $function[$result - 1]($first_arg) . "\n"; // Affiche le retour de la fonction
    }

    function advenced($result)
    {
        $function = ["encode_advanced_rle", "decode_advanced_rle"]; // Crée un tableau avec les fonctions avancées
        $first_arg = readline("mettez la source?\n"); // on enregistre l'input de l'utilisateur
        $seconde_arg = readline("mettez la destination\n");// Enregistre l'input de l'utilisateur
        echo $function[$result - 3]($first_arg, $seconde_arg) . "\n"; // Affiche le retour de la fonction
    }

    $i = 0;
    while(1){ // Boucle infinie
        choice(start($i)); // Lance la fonction principal
        $i++;
        $continue = readline("pour arretez mettez n, toute autre chose pour continuer?\n"); // Demande à l'utilisateur s'il veut continuer
        if (strpos($continue, "n") !== false) // Si l'utilisateur veut arreter on stop la boucle infinie sinon on relance la fonction principale
>>>>>>> 861f94a0754eeaa7f86aaf62fe1c38b735cebf48
            break;
    }
?>