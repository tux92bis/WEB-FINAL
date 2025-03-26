<?php
function connexionBDD() {
    $emplacement_BDD = __DIR__ . '/../BDD/stage-horizon';
    return new PDO("sqlite:$emplacement_BDD", null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
