@extends('layouts.master')

@section('main-content')

<div class="container d-flex justify-content-center align-items-center mt-4" style="min-height: 80vh;">
    <div class="card shadow p-4 w-100" style="max-width: 500px;">
        <h3 class="text-center mb-4">🔒 Changer votre mot de passe</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8">
            </div>

            <button type="submit" class="btn btn-primary w-100">✅ Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
