<?php
require '../config.php';
require_once "$C->add_dir/init.php";

$exceptions = array('e_developer','e_syntax','e_hack','e_spam','e_system');
$rand_excemption = $exceptions[array_rand($exceptions)];

echo $rand_excemption;
throw new $rand_excemption('ERROR!');
?>