<!DOCTYPE html>
<html>

<head>
    <title>Messe Créée</title>
</head>

<body>
    <h1>Détails de la Messe</h1>
    <p>Bonjour {{ $celebrant }},</p>
    <p>Une nouvelle messe a été programmée avec les détails suivants :</p>
    <ul>
        <li><strong>Date :</strong> {{ $date_messe }}</li>
        <li><strong>Heure :</strong> {{ $heure_messe }}</li>
        <li><strong>Lieu :</strong> {{ $lieu_messe }}</li>
    </ul>
    <p>Merci de votre service.</p>
</body>

</html>