@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Remplacer le Pain du Jour Automatique</h4>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('remplacer_pain_auto_action', $pain->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre', $pain->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="contenu">Contenu :</label>
            <textarea name="contenu" id="contenu" class="form-control" rows="5" required>{{ old('contenu', $pain->contenu) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Remplacer le message</button>
        <a href="{{ route('formPainJour') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
