<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation</title>
    <link rel="stylesheet" href="Styles/styles1.css">
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
.aa {
        padding: 35px;
        width: 30%;
        margin: 50px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        box-shadow: 3px 3px 3px 3px purple;
        transform:translate(80%);
        margin-top: 130px;
        background-color: rgba(255, 255, 255, 0.5);
    }
</style>
<body>
    <header>
        <div class="logo">
            <img src="Image/15.jpg" alt="Hotel Logo" height="70">
        </div>
        <nav class="navbar">
            <a href="S'inscrit.html">Compte</a>
            <a href="home.html">Home</a>
            <a href="about.html">About</a>
            <a href="contacter.html">Contact</a>
        </nav>
    </header>
    <div class="aa">
<?php
// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "projet");

// Vérifier la connexion
if (!$conn) {
    die("<p>Erreur de connexion à la base de données : " . mysqli_connect_error()."</p>");
}


    // Récupérer les données du formulaire
    $cin = $_POST['cin'];
    $np = $_POST['np'];
    $email = $_POST['email'];
    $num = $_POST['num'];
    $hotel = $_POST['hotel'];
    $date_A = $_POST['date_A'];
    $date_S = $_POST['date_S'];

    // Vérifier si le client existe déjà
    $req1 = mysqli_query($conn, "SELECT * FROM client WHERE Cin=$cin");
    if (mysqli_num_rows($req1) >= 1) {
        echo "<p>Client existe déjà.</p>";

        // Vérifier si une réservation existe déjà pour ce client
        $req2 = mysqli_query($conn, "SELECT * FROM reservation WHERE Cin=$cin");
        if (mysqli_num_rows($req2) >= 1) {
            echo "<p>Réservation existe déjà.</p>";
            $sql = "INSERT INTO reservation (Cin, Nom_Prenom, Email, Nombre_personnes, Date_A, Date_S, Hotel) 
                    VALUES ($cin, '$np', '$email', $num, '$date_A', '$date_S', '$hotel')";
            if (mysqli_query($conn, $sql)) {
                echo "<p>Outre Réservation ajoutée avec succès.</p>";
            } else {
                echo "<p>1ere Erreur lors de l'ajout de la réservation : " . mysqli_error($conn) . "</p>";
            }
        } else {
            // Insérer une nouvelle réservation
            $sql = "INSERT INTO reservation (Cin, Nom_Prenom, Email, Nombre_personnes, Date_A, Date_S, Hotel) 
                    VALUES ($cin, '$np', '$email', $num, '$date_A', '$date_S', '$hotel')";
            if (mysqli_query($conn, $sql)) {
                echo "<p>Réservation ajoutée avec succès.<br>";
            } else {
                echo "2eme Erreur lors de l'ajout de la réservation : " . mysqli_error($conn) . "</p>";
            }
        }
    } else {
        // Insérer un nouveau client
        $sql2 = "INSERT INTO client (Cin, Nom_Prenom, Email) 
            VALUES ($cin, '$np', '$email')";
        if (mysqli_query($conn, $sql2)) {
            echo "<p>Client ajouté avec succès.</p>";

            // Insérer une nouvelle réservation pour ce client
            $sql3 = "INSERT INTO reservation (Cin, Nom_Prenom, Email, Nombre_personnes, Date_A, Date_S, Hotel) 
                     VALUES ($cin,'$np','$email',$num,'$date_A','$date_S','$hotel')";
            if (mysqli_query($conn, $sql3)) {
                echo "<p>Réservation ajoutée avec succès.</p>";
            } else {
                echo "<p>Erreur lors de l'ajout de la réservation : " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p>Erreur lors de l'ajout du client : " . mysqli_error($conn) . "</p>";
        }
    }


// Fermer la connexion
mysqli_close($conn);
?>
</div>
</body>
</html>

