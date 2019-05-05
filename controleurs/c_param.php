<?php
define ('Host','localhost');
define ('datebase','gsb');
define ('Login','root');
define ('password','');
define ('charset','utf8');
function connect(){
  try {
    $connec= new PDO("mysql:host=".Host.";dbname=".datebase.";charset=".charset,Login,password);
    return $connec;
  } catch (PDOException $e) {
    echo "Erreur : ".$e->getMessage();
  }

}

 ?>
