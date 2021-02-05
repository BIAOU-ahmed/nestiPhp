<?php

// require_once $vars['templatesPath'].'common/navigation.php';
echo "<h1>Users</h1>";
foreach($vars['entities'] as $user){
echo "<div>". $user->getId() ."</div>";
}