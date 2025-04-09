<?php
// Configuration de l'en-tête Content-Type
header('Content-Type: text/html; charset=UTF-8');

// Connexion sécurisée à la base de données
try {
    $conn = new mysqli("localhost", "root", "", "projet");
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("<p>Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()) . "</p>");
}

// Vérification des champs obligatoires
$required_fields = ['cin', 'np', 'hotel'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        header('Location: Annuler.html');
        exit();
    }
}

// Validation et nettoyage des données
$cin = filter_input(INPUT_POST, 'cin', FILTER_VALIDATE_INT);
if ($cin === false || $cin <= 0) {
    echo "<script>
            alert('Le CIN doit être un nombre valide.');
            window.location.href = 'Annuler.html';
          </script>";
    exit();
}

$np = trim($_POST['np']);
$hotel = trim($_POST['hotel']);

if (empty($np) || empty($hotel)) {
    header('Location: Annuler.html');
    exit();
}

// Préparation et exécution des requêtes avec gestion des erreurs
try {
    // Vérification de l'existence de la réservation
    $check_query = "SELECT COUNT(*) FROM reservation WHERE Cin = ? AND Nom_Prenom = ? AND Hotel = ?";
    $check_stmt = $conn->prepare($check_query);
    
    if (!$check_stmt) {
        throw new Exception("Erreur de préparation de la requête : " . $conn->error);
    }
    
    $check_stmt->bind_param("iss", $cin, $np, $hotel);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();
    
    if ($count == 0) {
        throw new Exception("Aucune réservation trouvée pour ces informations.");
    }
    
    // Suppression de la réservation
    $delete_query = "DELETE FROM reservation WHERE Cin = ? AND Nom_Prenom = ? AND Hotel = ?";
    $delete_stmt = $conn->prepare($delete_query);
    
    if (!$delete_stmt) {
        throw new Exception("Erreur de préparation de la requête de suppression : " . $conn->error);
    }
    
    $delete_stmt->bind_param("iss", $cin, $np, $hotel);
    
    if (!$delete_stmt->execute()) {
        throw new Exception("Erreur lors de l'annulation de la réservation : " . $delete_stmt->error);
    }
    
    $rows_affected = $delete_stmt->affected_rows;
    $delete_stmt->close();
    
    if ($rows_affected == 0) {
        throw new Exception("Aucune réservation n'a été annulée (ligne non affectée).");
    }
    
    // Succès
    echo "<script>
            alert('Réservation annulée avec succès.');
            window.location.href = 'Reservation.php';
          </script>";
    
} catch (Exception $e) {
    // Gestion des erreurs
    echo "<script>
            alert('" . addslashes(htmlspecialchars($e->getMessage())) . "');
            window.location.href = 'Annuler.html';
          </script>";
} finally {
    // Fermeture de la connexion
    if (isset($conn)) {
        $conn->close();
    }
}
exit();
?>