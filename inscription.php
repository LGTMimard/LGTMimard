<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $etablissement = htmlspecialchars($_POST["etablissement"]);
    $specialite = htmlspecialchars($_POST["specialite"]);
    $date = htmlspecialchars($_POST["date"]);

    // Adresse email du responsable
    $to = "ddf.0420046x@ac-lyon.fr";
    $subject = "Nouvelle inscription - Stage Immersion STI2D";
    $message = "
        <html>
        <head>
            <title>Nouvelle inscription</title>
        </head>
        <body>
            <h2>Nouvelle inscription reçue</h2>
            <p><strong>Nom :</strong> $nom</p>
            <p><strong>Prénom :</strong> $prenom</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Téléphone :</strong> $telephone</p>
            <p><strong>Établissement :</strong> $etablissement</p>
            <p><strong>Spécialité choisie :</strong> $specialite</p>
            <p><strong>Date de participation :</strong> $date</p>
        </body>
        </html>
    ";

    // En-têtes de l'email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: noreply@tonsite.com" . "\r\n"; // Remplace par un vrai domaine

    // Envoi de l'email
    if (mail($to, $subject, $message, $headers)) {
        echo "Inscription envoyée avec succès !";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }

    // Stockage dans un fichier CSV
    $file = 'inscriptions.csv';
    $data = [$nom, $prenom, $email, $telephone, $etablissement, $specialite, $date];

    if (!file_exists($file)) {
        $header = ["Nom", "Prénom", "Email", "Téléphone", "Établissement", "Spécialité", "Date"];
        $csvFile = fopen($file, "w");
        fputcsv($csvFile, $header);
    } else {
        $csvFile = fopen($file, "a");
    }

    fputcsv($csvFile, $data);
    fclose($csvFile);
}
?>
