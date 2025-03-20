<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #15d387;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .info {
            margin-bottom: 20px;
        }

        .info label {
            font-weight: bold;
        }

        .info p {
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reçu de Paiement</h1>
        {{-- @php
        dd($recu);
        @endphp --}}
        <div class="info">
            <label>Nom et Prénom:</label>
            <p>{{ $recu->nom_prenom }}</p>
        </div>

        <div class="info">
            <label>Montant:</label>
            <p>{{ $recu->montant }} FCFA</p>
        </div>

        <div class="info">
            <label>Contact:</label>
            <p>{{ $recu->contact }}</p>
        </div>

        <div class="info">
            <label>Date de Paiement:</label>
            <p>{{ \Carbon\Carbon::parse($recu->date_paiement)->format('d/m/Y') }}</p>
        </div>
        <div class="footer">
            <p>Merci pour votre paiement.</p>
            <p>Veuillez envoyer ce reçu au secrétariat pour récupérer vos manuels.</p>
            <a href="{{ route('download.recu', ['id_paiement' => $recu->id_paiement]) }}"
                class="btn btn-secondary">Télécharger le
                Reçu</a>
            <a href="{{ route('accueil') }}" class="btn btn-primary">Retour à l'accueil? </a>

        </div>
    </div>
</body>

</html>