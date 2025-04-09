<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Formulaire d'inscription</title>
</head>
<style>
p{
    color: black;
    font-size: 20px;
    text-align: center;
    font-family: 'Arial';
    font-weight: bold;
}
body {
    background: url("Image/2.jpg") no-repeat;
    background-size: cover;
    background-position: center;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
nav {
    padding: 35px;
    background:white;
    width: 30%;
    margin: 50px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s;
    box-shadow: 3px 3px 3px 3px purple;
    transform:translate(80%);
}
</style>
<body>
   <nav>
<?php
// Activation des erreurs PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Connexion à la base de données réussie.</p>"; // Ajout d'un message de succès
} catch (PDOException $e) {
    die("<p>Erreur de connexion à la base de données : " . $e->getMessage()."</p>");
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $cin = $_POST['cin'] ?? null;
    $nom = $_POST['np'] ?? null;

    echo "<p>CIN reçu : " . htmlspecialchars($cin) . "</p>"; // Affichage pour débogage
    echo "<p>Nom reçu : " . htmlspecialchars($nom) . "</p>"; // Affichage pour débogage

    // Vérification si les champs sont remplis
    if (!empty($cin) && !empty($nom)) {
        // Préparation de la requête SQL sécurisée
        $stmt = $pdo->prepare("SELECT * FROM client WHERE Cin = :cin AND Nom_Prenom = :nom");
        if ($stmt === false) {
            die("<p>Erreur de préparation de la requête : " . print_r($pdo->errorInfo(), true)."</p>");
        }
        $stmt->bindParam(':cin', $cin);
        $stmt->bindParam(':nom', $nom);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Vérification des résultats
            if ($stmt->rowCount() > 0) {
                echo "<p>Informations valides. Redirection vers hotel1.html</p>"; // Message de débogage
                ?>
                <?php if (count($clients) > 0) : ?>
                    <section class="hotels">
                <p class="typing-effect" style="margin: 20px auto;
                box-shadow: 3px 3px 3px purple;">welcome <?php echo htmlspecialchars($nom) ?>.... </p>
            <div class="client-container">
                    <table>
                        <thead>
                            <tr>
                                <th>CIN</th>
                                <th>Nom & Prénom</th>
                                <th>Email</th>
                                <th>Nombre_personnes</th>
                                <th>Date_A</th>
                                <th>Date_S</th>
                                <th>Hotel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($client['Cin']) ?></td>
                                    <td><?= htmlspecialchars($client['Nom_Prenom']) ?></td>
                                    <td><?= htmlspecialchars($client['Email']) ?></td>
                                    <td><?= htmlspecialchars($client['Nombre_personnes']) ?></td>
                                    <td><?= htmlspecialchars($client['Date_A']) ?></td>
                                    <td><?= htmlspecialchars($client['Date_S']) ?></td>
                                    <td><?= htmlspecialchars($client['Hotel']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <?php else: ?>
                    <section class="hotels">
                        <div class="client-container">
                            <p>Le CIN et/ou le nom ne sont pas valides.</p>
                            <p>Verifier votre CIN et votre nom
                            <a href="s'inscrit.html">Compte</a></p>
                            <p>Si vous n'avez pas de compte, veuillez vous reserver
                            <a href="Reservation.html">Reservation</a></p>
                    <?php endif; ?>
                        </div>
                    </section>?>
                <?php
            }
        } else {
            echo "<p >Erreur lors de l'exécution de la requête : " . print_r($stmt->errorInfo(), true)."</p>";
        }
    } else {
        echo "<p>Veuillez remplir tous les champs.</p>";
    }
}
?>
</nav> 
</body>
</html>
