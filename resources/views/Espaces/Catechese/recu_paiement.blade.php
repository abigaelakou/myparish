<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement Catéchèse</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
            color: #333;
            font-size: 13px;
        }

        /* Header compact */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            border-bottom: 2px solid #15d387;
            padding-bottom: 10px;
        }

        .header img.logo {
            width: 50px;
            height: auto;
        }

        .header .header-text {
            text-align: right;
            flex: 1;
            margin-left: 15px;
        }

        .header h2 {
            color: #15d387;
            margin: 0;
            font-size: 16pt;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .section {
            margin-bottom: 18px;
        }

        .section h3 {
            background-color: #15d387;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .info-table td {
            padding: 5px 6px;
            vertical-align: top;
        }

        .info-table td.label {
            width: 40%;
            font-weight: bold;
        }

        .bordered {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            border-top: 1px dashed #aaa;
            padding-top: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('assets/images/logo/logo2.png')}}" style="max-width: 60%; max-height: 80px; margin-right:auto; margin-left:auto; margin-top:8%;display:block;" class="logo" alt="Logo Paroisse Smart">
        <div class="header-text">
            <h2>Reçu de Paiement - Catéchèse</h2>
            <p>Paroisse : {{ $recu->inscription->paroisse->nom_paroisse ?? 'Non spécifiée' }}</p>
            <p>Année catéchétique : {{ $recu->inscription->annee_catechetique ?? 'Non définie' }}</p>
        </div>
    </div>

    <div class="section bordered">
        <h3>Catéchumène</h3>
        <table class="info-table">
            <tr>
                <td class="label">Nom et prénom :</td>
                <td>{{ $recu->inscription->catechumene->name ?? '' }} {{ $recu->inscription->catechumene->prenom ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Niveau :</td>
                <td>{{ $recu->inscription->niveau->lib_niveau ?? 'Non spécifié' }}</td>
            </tr>
            <tr>
                <td class="label">Session :</td>
                <td>{{ $recu->inscription->session->lib_session_catechese ?? 'Non spécifiée' }}</td>
            </tr>
            <tr>
                <td class="label">Date d'inscription :</td>
                <td>{{ $recu->inscription->date_inscription ? \Carbon\Carbon::parse($recu->inscription->date_inscription)->format('d/m/Y') : 'Non définie' }}</td>
            </tr>
        </table>
    </div>

    <div class="section bordered">
        <h3>Paiement</h3>
        <table class="info-table">
            <tr>
                <td class="label">Montant payé :</td>
                <td>{{ number_format($recu->montant ?? 0, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td class="label">Mode :</td>
                <td>{{ $recu->mode_paiement ?? 'Non renseigné' }}</td>
            </tr>
            <tr>
                <td class="label">Contact :</td>
                <td>{{ $recu->contact ?? 'Non renseigné' }}</td>
            </tr>
            <tr>
                <td class="label">Statut :</td>
                <td>{{ $recu->payment_status ?? 'Non défini' }}</td>
            </tr>
            <tr>
                <td class="label">Date :</td>
                <td>{{ $recu->date_paiement ? \Carbon\Carbon::parse($recu->date_paiement)->format('d/m/Y à H:i') : 'Non définie' }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p><strong>Merci pour votre participation à la vie de la paroisse.</strong></p>
        <p>Conservez ce reçu comme preuve de paiement.</p>
    </div>
</body>

</html>
