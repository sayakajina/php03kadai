<?php
    $pw = password_hash('test02',PASSWORD_DEFAULT);
    echo $pw;
    echo "</br>";
    $pw2 = password_hash('test02',PASSWORD_DEFAULT);
    echo $pw2;



?>