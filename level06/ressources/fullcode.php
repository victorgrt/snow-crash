<?php
function y($m) {
    $m = preg_replace("/\./", " x ", $m); // on remplace les . par des x
    $m = preg_replace("/@/", " y", $m); // on remplace les @ par des y
    return $m;
}

function x($y, $z) {
    // on chope le contenu du fichier argv[1]
    $a = file_get_contents($y);
    // dans la ligne du dessous l'utilisatipon de l'option e de preg_replace est dangereuse, elle permet d'exécuter des commandes shell lors de l'interpretation
    $a = preg_replace("/(\[x (.*)\])/e", "y(\"\\2\")", $a);
    $a = preg_replace("/\[/", "(", $a); // on remplace les [ par des (
    $a = preg_replace("/\]/", ")", $a); // on remplace les ] par des )
    return $a;
}

// grossomodo on et on fait des operations regex sur le contenu du fichier argv[1] et on affiche le resultat
// on peut donc executer du code arbitraire en mettant des commandes shell dans le fichier argv[1] si on les met au bon format, c'est à dire [x <commande>]
$r = x($argv[1], $argv[2]); 
print $r;

?>

