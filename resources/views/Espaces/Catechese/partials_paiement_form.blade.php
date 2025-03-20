{{-- <div class="modal fade modal-lg" id="editPaiementModal" tabindex="-1" role="dialog"
    aria-labelledby="editPaiementModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                <div class="modal-body">
                    <form class="row g-3" action="{{ route('validation_paiementCatechese') }} " method="POST"
                        id="editPaiementForm">
                        @csrf
                        <input type="hidden" name="id_inscription" value="{{ $paiement->id_inscription }}">

                        <div class="col-md-3 position-relative">
                            <label for="montant">Montant à payer :</label>
                            <input type="number" name="montant" value="{{ $paiement->montant }}" step="0.01" required>
                        </div>

                        <div class="col-md-3 position-relative">
                            <label for="contact">Numéro de téléphone :</label>
                            <input type="tel" name="contact" value="{{ old('contact') }}" pattern="[0-9]{8,14}" required
                                title="Veuillez entrer un numéro de téléphone valide entre 8 et 14 chiffres">
                            @error('contact')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 position-relative">
                            <label for="mode_paiement">Mode de paiement :</label>
                            <select name="mode_paiement" required>
                                <option value="" disabled selected>Choisissez un mode de paiement</option>
                                <option value="moov">Moov</option>
                                <option value="orange">Orange</option>
                                <option value="mtn">MTN</option>
                                <option value="wave">Wave</option>
                            </select>
                            @error('mode_paiement')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button class="btn btn-secondary" type="submit">Payer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends--> --}}
</div>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000); 
    
</script>

@section('page-js')
@section('scripts')
<script src="{{asset('js/pages_js/catechumene.js')}}" defer></script>
@endsection