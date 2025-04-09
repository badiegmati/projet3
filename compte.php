<?php
// Activation des erreurs PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Récupération depuis POST ou GET
$cin = $_POST['cin'] ?? $_GET['cin'] ?? null;
$nom = $_POST['np'] ?? $_GET['np'] ?? null;

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifier que le CIN et le nom sont valides avant de faire la requête
if (!empty($cin) && !empty($nom)) {
    try {
        // Requête préparée avec vérification du CIN et du nom
        $stmt = $pdo->prepare("SELECT c.Cin, c.Nom_Prenom, c.Email, 
                             r.Nombre_personnes, r.Date_A, r.Date_S, r.Hotel 
                             FROM client c 
                             LEFT JOIN reservation r ON c.Cin = r.Cin 
                             WHERE c.Cin = :cin AND c.Nom_Prenom = :nom");
        $stmt->bindParam(':cin', $cin, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si aucun résultat mais le client existe
        if (empty($clients)) {
            $stmt = $pdo->prepare("SELECT * FROM client WHERE Cin = :cin AND Nom_Prenom = :nom");
            $stmt->bindParam(':cin', $cin, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    } catch (PDOException $e) {
        die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }
} else {
    $clients = [];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Client</title>
    <link rel="stylesheet" href="Styles/styles1.css">
    <style>
        /* Votre CSS existant */
    </style>
</head>
<style>
    /* Reset et Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    color: #333;
    line-height: 1.6;
    overflow-x: hidden;
}
.navbar a:hover {
    color: #4a90e2;
    text-decoration: none;
}
/* Slider Animé */
.slider {
    width: 100%;
    min-height: 100vh;
    background-size: cover;
    background-position: center;
    animation: slider 15s infinite ease-in-out;
    padding-top: 100px;
}

@keyframes slider {
    0%, 100% { background-image: url('Image/hotel1_2.jpg'); }
    25% { background-image: url('Image/hotel1_3.jpg'); }
    50% { background-image: url('Image/hotel1_4.jpg'); }
    75% { background-image: url('Image/hotel1_5.jpg'); }
}

/* Section Client */
.hotels {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 20px;
    color: black;
}


.client-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    margin: 2rem 0;
    color: #000;
}

.client-info, .client-images {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    padding: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
}

.client-info:hover, .client-images:hover {
    transform: translateY(-5px);
}

.client-info {
    flex: 1;
    min-width: 300px;
    
}

.client-info p {
    margin: 10px 0;
    font-size: 1.1rem;
    color: black;
}

.client-info strong {
    color: #4a90e2;
}
.s {
    color:#000;
    font-size: 1.2rem;
    margin: 10px 0;
    text-align: center;
    font-weight: bold;
}

.client-images {
    flex: 1;
    min-width: 300px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
    align-content: start;
}

.client-images img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s;
}

.client-images img:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

/* Messages d'erreur */
.hotels > .client-container p {
    color: white;
    text-align: center;
    font-size: 1.2rem;
    margin: 10px 0;
}

.hotels a {
    color: #4a90e2;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .client-container {
        flex-direction: column;
    }

    .client-info, .client-images {
        width: 100%;
        olor: black;
    }

    .navbar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .navbar a {
        margin: 5px 10px;
    }
}

</style>

<body class="slider">
    <header>
        <div class="logo">
            <img src="Image/15.jpg" alt="Hotel Logo" height="70">
        </div>
        <nav class="navbar">
            <a href="S'inscrit.html">Compte</a>
            <a href="index.html">Home</a>
            <a href="Reservation.html">Reserver</a>
            <a href="Annuler.html">Annuler </a>
        </nav>
    </header>

    <?php if (!empty($clients)): ?>
        <section class="hotels">
            <p class="typing-effect" style="margin: 20px auto; box-shadow: 3px 3px 3px purple;">
                Welcome <?= htmlspecialchars($nom) ?>....
            </p>
            <?php foreach ($clients as $client): ?>
                <div class="client-container">
                    <div class="client-info">
                        <p style="color:red;"><strong> Voici votre Reservation :</strong></p>
                        <p><strong>CIN :</strong> <span class="s"><?= htmlspecialchars($client['Cin']) ?></span></p>
                        <p><strong>Nom & Prénom :</strong> <span class="s"><?= htmlspecialchars($client['Nom_Prenom']) ?></span></p>
                        <p><strong>Email :</strong> <span class="s"><?= htmlspecialchars($client['Email']) ?></span></p>

                        <?php if (isset($client['Nombre_personnes'])): ?>
                            <p><strong>Nombre de personnes :</strong> <span class="s"><?= htmlspecialchars($client['Nombre_personnes']) ?></span></p>
                            <p><strong>Date d'arrivée :</strong> <span class="s"><?= htmlspecialchars($client['Date_A']) ?></span></p>
                            <p><strong>Date de départ :</strong> <span class="s"><?= htmlspecialchars($client['Date_S']) ?></span></p>
                            <p><strong>Hôtel :</strong> <span class="s"><?= htmlspecialchars($client['Hotel']) ?></span></p>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($client['Hotel']) && $client['Hotel'] === "Royal Azur Hotel Thalassa"): ?>
                        <div class="client-images">
                            <img src="Image/hotel1_1.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel1_2.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel1_3.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel1_4.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel1_5.jpg" alt="Royal Azur Hotel Thalassa">
                        </div>
                    <?php elseif (isset($client['Hotel']) && $client['Hotel'] === "Hotel Royal Jiinene"): ?>
                        <div class="client-images">
                            <img src="Image/hotel2_1.jpg" alt="Hotel Royal Jiinene">
                            <img src="Image/hotel2_2.jpg" alt="Hotel Royal Jiinene">
                            <img src="Image/hotel2_3.jpg" alt="Hotel Royal Jiinene">
                            <img src="Image/hotel2_4.jpg" alt="Hotel Royal Jiinene">
                            <img src="Image/hotel2_5.jpeg" alt="Hotel Royal Jiinene">
                        </div>
                    <?php elseif (isset($client['Hotel']) && $client['Hotel'] === "Mahdia Beach & Aquapark"): ?>
                        <div class="client-images">
                            <img src="Image/hotel3_1.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel3_2.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel3_3.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel3_4.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel3_5.jpg" alt="Royal Azur Hotel Thalassa">
                        </div>
                    <?php elseif (isset($client['Hotel']) && $client['Hotel'] === "The Residence Douz"): ?>
                        <div class="client-images">
                            <img src="Image/hotel4_1.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel4_2.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel4_3.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel4_4.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel4_5.jpg" alt="Royal Azur Hotel Thalassa">
                        </div>
                    <?php elseif (isset($client['Hotel']) && $client['Hotel'] === "Le Petit Palais & Spa"): ?>
                        <div class="client-images">
                            <img src="Image/hotel5_1.jpg" alt="Le Petit Palais & Spa">
                            <img src="Image/hotel5_2.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel5_3.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel5_4.jpg" alt="Royal Azur Hotel Thalassa">
                            <img src="Image/hotel5_5.jpg" alt="Royal Azur Hotel Thalassa">

                        </div>

                    <?php else: ?>
                        <div class="client-images">
                            <img src="Image/hotel6_1.jpg" alt="La Cigale">
                            <img src="Image/hotel6_2.jpg" alt="La Cigale">
                            <img src="Image/hotel6_3.jpg" alt="La Cigale">
                            <img src="Image/hotel6_4.jpg" alt="La Cigale">
                            <img src="Image/hotel6_5.jpg" alt="La Cigale">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </section>
    <?php else: ?>
        <section class="hotels">
            <div class="client-container">
                <p>Le CIN et/ou le nom ne sont pas valides.</p>
                <p>Verifier votre CIN et votre nom
                    <a href="s'inscrit.html">Compte</a>
                </p>
                <p>Si vous n'avez pas de compte, veuillez vous reserver
                    <a href="Reservation.html">Reservation</a>
                </p>
            </div>
        </section>
    <?php endif; ?>
</body>

</html>