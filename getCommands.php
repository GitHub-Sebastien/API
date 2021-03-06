<?php
include 'db_connect.php';

if(!empty($_GET['user'])){

    $db = db_connect() ;
    
    $id = $_GET['user'] ;
    
    $cmds = $db->query('SELECT * FROM commande WHERE Utilisateur_idUser='.$id);
    
    $commands = Array();
    
    while($row = $cmds->fetch()){
        $commands[$row['idCommande']] = Array();
    
        $items = $db->query('SELECT Quantité, Nom, Prix FROM produitscommande
                            INNER JOIN commande ON Commande_idCommande=idCommande
                            INNER JOIN produits ON Produits_idProduits=idProduits
                            WHERE Commande_idCommande='.$row["idCommande"]);
        
        while($itm = $items->fetch()){
            $commands[$row['idCommande']][] = ['nom'=>$itm['Nom'], 'qty' => $itm['Quantité'], 'price' => $itm['Prix'] ];
        }
       $commands[$row['idCommande']]['date'] = $row['Datedecommande'];
    }
    header('Content-Type: application/json');
    echo json_encode($commands, JSON_PRETTY_PRINT);

}
