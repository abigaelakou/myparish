@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📖 Pain du Jour</h3>

    @if ($painAujourdhui)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $painAujourdhui->titre }}</h5>
                <p class="card-text">{{ $painAujourdhui->contenu }}</p>
                <p class="text-muted text-end mb-0"><small>{{ \Carbon\Carbon::parse($painAujourdhui->date_pain)->format('d/m/Y') }}</small></p>
            </div>
        </div>
    @else
        <div class="alert alert-info">Aucun pain du jour publié aujourd’hui pour votre paroisse.</div>
    @endif

    <hr>

    <h4 class="mt-4">📚 Historique</h4>

    <form method="GET" action="{{ route('utilisateur.pain_du_jour') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="date" class="form-label">Filtrer par date :</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    @if ($pains->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Titre</th>
                    <th>Contenu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pains as $pain)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($pain->date_pain)->format('d/m/Y') }}</td>
                        <td>{{ $pain->titre }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($pain->contenu, 80) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $pains->links() }}
@else
    <p>Aucun message trouvé pour cette date.</p>
@endif

</div>
@endsection
