<?php
require '../config.php';
require_once "$C->add_dir/init.php";

add::config()->environment_status = 'live';

$exceptions = array('e_developer','e_syntax','e_hack','e_spam','e_system');
$rand_excemption = $exceptions[array_rand($exceptions)];

throw new $rand_excemption('ERROR! '.$rand_excemption);
?>