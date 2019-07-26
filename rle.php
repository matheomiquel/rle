<?php 
    function encode_rle(string $str)
    {
        $compress; //variable
        $modele = $str[0]; //le premier caractère sera enregistré dans la variable modele
        $a = 0; //variable

        if (!ctype_alpha($str) or strlen($str) == 0) //  Verifie si la string envoyé est seulement composée de caractères alpha et également si elle n'est pas vide
            return ("$$$"); // Si vide alors on renvoie la string "$$$"
        for ($i = 0; $i < strlen($str);$i++) { // Boucle jusqu'a la fin de la taille de la string caractere par caractere
            if ($modele[0] == $str[$i]) // Si le caractere contenue dans modele est strictement égal à celui dans la string à l'index i
                $a++; // On incremente donc une variable nommée a
            else {      // sinon
                $compress .= $a . $str[$i -1]; // On concatene dans la variable compress la valeur de a puis on stocke le caractere;
                $a = 1; // Réinitialise la variable a
                $modele[0] = $str[$i]; // On modifie la valeur de modele avec la valeur contenue dans str à l'index i
            }
        } 
        $compress .= $a . $str[$i - 1]; // Concatene dans la variable compress la valeur de a puis stocke le caractere;
        return ($compress); // Retourne la variable compress
    }

    function decode_rle(string $str)
    {
        $a;  //variable
        $string;  //variable
        $number = 0;  //variable

        if (!ctype_alnum($str) + strlen($str) == 0) // Verifie si la string envoyée est seulement composée de caracteres alphanumeriques et egalement si elle n'est pas vide
            return "$$$"; // Si vide alors on renvoie la string "$$$"
        for($i = 0;$i < strlen($str) ;$i++) // Boucle jusqu'a le fin de la taille de la string caractere par caractere
            if(ctype_alpha($str[$i]) and !is_numeric($str[$i - 1]))  // Verifie si c'est des chiffres qui precedent des lettres
                return ("$$$");// Si c'est le cas retourne "$$$"
        for ($i = 0;$i <= strlen($str); $i++) // Pour verifier la taille de str
            if (is_numeric($str[$i]))   // Verifie si les caracteres sont numériques
                $a .= $str[$i]; // Concatene le nombre dans la variable a
            else { // sinon
                for ($j = 0;$j < $a; $j++) // pour la variable a
                    $string .= $str[$i]; // Concatene dans la string le caractere à l'index i
                $a = 0; // Reinitialise la valeur de la variable a
            }
        return ($string); // Retourne string
    }



    function encode_advanced_rle(string $path_to_encode, string $result_path)
    {
        $repet = 1;
        $nonrepet = 0;

        if (!file_exists($path_to_encode) or exif_imagetype($path_to_encode) != 6) // Verifie si le fichier existe et si c'est bien un fichier bmp
            return "$$$"; // Sinon retourne "$$$"
        $output = file_get_contents($path_to_encode); // Recupere le contenu du fichier envoyé et l'affiche dans l'output
        for ($i = 0;$i < strlen($output);$i++) { // Pour chaque caractere affiche dans l'output
            if ($output[$i] == $output[$i + 1]) {  // Verifie si la string pour index i est strictement egale à string pour index i + 1 
                if ($repet < 255) // Si la variable repet est inferieure a un caractere de la table ASCII
                    $repet++;   // Incrementation de la variable repet
                else { // Sinon
                    $compression .=  chr($repet) . $output[$i]; // Concatene dans la variable compression
                    $repet = 1; // Reinitialise la variable repet a 1
                }
                if ($nonrepet != 0){ // Si la variable nonrepet est differente de 0 
                    $compression .=  chr(0) . chr($nonrepet) . $word; // Concatene chr(0) pour avoir la valeur 0 (et non l'ASCII qui vaut 48}
                    $word = ""; // Reinitialise la variable word
                }
                $nonrepet = 0; // Reinitialise la variable nonrepet à 0
            }
            else { // Sinon
                if ($repet > 1) // Verifie la variable repet
                    $compression .=  chr($repet) . $output[$i]; // Concatenation
                else {
                    if ($nonrepet == 255) { // Si la variable nonrepet est strictement egale a la valeur 255 dans la table ASCII
                        $compression .=  chr(0) . chr($nonrepet) . $word; // Concatene
                        $nonrepet = 0; // Reinitialise la variable nonrepet à 0
                        $word = ""; // Reinitialise la variable word
                    }
                    $word .= $output[$i]; // Concatene
                    $nonrepet++; // Incrementation de la variable nonrepet
                }
                $repet = 1; // Reinitialise la variable repet a 1
            }
        }
        if($nonrepet != 0) // Si la variable nonrepet est different de 0
            $compression .= chr(0) . chr($nonrepet) . $word; // Concatene
        file_put_contents($result_path, $compression); // On stocke le contenu de la variable compression dans le fichier qu'on a passé en argument
    }

    function decode_advanced_rle(string $path_to_uncode, string $result_path)
    {
        if (!file_exists($path_to_uncode)) // check if file exist, it name of function hoooo but we need comment for undrstand this fucking code you know fucking bastard, la chaleur c'est pas bien wesh sinon ça va la fammille tout ça je sais que y'a une faute a famille avant mais tg stp et sel sur paris ça sonne bien aussi pour le titre du film :D
            return ("$$$");
        $file = file_get_contents($path_to_uncode); // on met le contenue du fichier passé en arg dans la string 
        for ($i = 0;$i < strlen($file);$i++) { // boucle like usual 
            if ($file[$i] == chr(0)) {    // si jamais tu sais pas envoie un message fb
                $i++; // incrementation 
                $value = ord($file[$i]); // on met la value de file de i dans la $value
                for ($j = 0; $j < $value; $j++) { // boucle tant que j < value
                    $i++; // incrément
                    $decompress .= $file[$i]; // la concatenation
                }
            } else {
                $compt = $file[$i]; // ta compris fait pas genre
                $i++; // incrémentation
                for ($j = 0;$j < ord($compt) ;$j++) { 
                    $decompress .= $file[$i];  //et la on met juste tout les caractere bien comme il faut :)
                }
            }
        }
        file_put_contents($result_path, $decompress); // et la on envoie
    }

    function start($i){
        $result = 0;
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

    function choice($result){
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
        choice(start($i)); // on lance la fonction principal
        $i++;
        $continue = readline("pour arretez mettez n, toute autre chose pour continuer?\n"); // on demande a l'utilisateur si il veut continuer
        if (strpos($continue, "n") !== false) // si l'utilisateur veut stopper on break la boucle inf sinon on relance la fonction principale
            break;
    }
?>