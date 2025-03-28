<?php

public function offresFiltrees($filtres) {
    $sql = "SELECT o.*, 
            (SELECT COUNT(*) FROM Favoris f WHERE f.id_offre = o.id_offre AND f.id_etudiant = :user_id) as est_favori
            FROM OffreStage o WHERE 1=1";
    
    // Utiliser l'ID de l'utilisateur connecté avec une valeur par défaut
    $user_id = $_SESSION['utilisateur']['id'] ?? 0;
    $params = [':user_id' => $user_id];
    
    // ... reste du code ...
} 