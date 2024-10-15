<!DOCTYPE html>
<html>

<head>
    <title>Demandes de Messes - {{ Carbon\Carbon::tomorrow()->toDateString() }}</title>
</head>

<body>
    <h1 class="text-center">Liste des demandes de messe du {{ Carbon\Carbon::tomorrow()->toDateString() }}</h1>
    <table border="1" class="display table table-striped table-bordered" style="width:100% !important">
        <thead class="bg-white text-black">
            <tr>
                <th>Type d'intention</th>
                <th>Description</th>
                <th>Heure</th>
                <th>Lieu</th>
                <th>Demandée par:</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandesMesses as $demande)
            <tr>
                <td>{{ $demande->type_intention }}</td>
                <td>{{ $demande->intentions }}</td>
                <td>{{ $demande->lieu_messe }}</td>
                <td>{{ $demande->heure_messe }}</td>
                <td>{{ $demande->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>