@csrf

<div class="row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="col-lg-12 px-4 mb-0">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <label for="nume" class="mb-0 pl-3">Nume:*</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $piesa->nume) }}"
                    required>
            </div>
            <div class="col-lg-12 mb-4">
                    <label for="artist_id" class="mb-0 pl-3">Artist:</label>
                    <div class="">
                        <select name="artist_id"
                            class="form-select bg-white rounded-3 {{ $errors->has('artist_id') ? 'is-invalid' : '' }}"
                        >
                                <option value='' selected>Selectează artist</option>
                            @foreach ($artisti as $artist)
                                <option
                                    value='{{ $artist->id }}'
                                    {{ ($artist->id == old('artist_id', ($piesa->artist->id ?? ''))) ? 'selected' : '' }}
                                >{{ $artist->nume }} </option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-lg-12 mb-4">
                <label for="link_youtube" class="mb-0 pl-3">Link youtube:</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('link_youtube') ? 'is-invalid' : '' }}"
                    name="link_youtube"
                    placeholder=""
                    value="{{ old('link_youtube', $piesa->link_youtube) }}"
                    required>
            </div>
            <div class="col-lg-12 mb-4">
                <label for="link_interviu" class="mb-0 pl-3">Link interviu:</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('link_interviu') ? 'is-invalid' : '' }}"
                    name="link_interviu"
                    placeholder=""
                    value="{{ old('link_interviu', $piesa->link_interviu) }}"
                    required>
            </div>
            <div class="col-lg-12 mb-4">
                <label for="categorie" class="mb-0 pl-3">Categorie:*</label>
                <select name="categorie" class="form-select bg-white rounded-3 {{ $errors->has('client_deja_inregistrat') ? 'is-invalid' : '' }}">
                    <option value="">Selectează categorie</option>
                    <option value="Top International" {{ (old('categorie', $piesa->categorie) == "Top International") ? 'selected' : '' }}>Top International</option>
                    <option value="Top Romanesc" {{ (old('categorie', $piesa->categorie) == "Top Romanesc") ? 'selected' : '' }}>Top Romanesc</option>
                    <option value="Top Cea mai buna muzica veche" {{ (old('categorie', $piesa->categorie) == "Top Cea mai buna muzica veche") ? 'selected' : '' }}>Top Cea mai buna muzica veche</option>
                    <option value="Propunere Top International" {{ (old('categorie', $piesa->categorie) == "Propunere Top International") ? 'selected' : '' }}>Propunere Top International</option>
                    <option value="Propunere Top Romanesc" {{ (old('categorie', $piesa->categorie) == "Propunere Top Romanesc") ? 'selected' : '' }}>Propunere Top Romanesc</option>
                    <option value="Propunere Top Cea mai buna muzica veche" {{ (old('categorie', $piesa->categorie) == "Propunere Top Cea mai buna muzica veche") ? 'selected' : '' }}>Propunere Cea mai buna muzica veche</option>
                </select>
            </div>
            <div class="col-lg-12 mb-4">
                <label for="voturi" class="mb-0 pl-3">Voturi:</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('voturi') ? 'is-invalid' : '' }}"
                    name="voturi"
                    placeholder=""
                    value="{{ old('voturi', $piesa->voturi) }}"
                    required>
            </div>
        </div>

        {{-- salvarea ultimului URL, pentru intoarcerea la Topul corespunzator --}}
        <input type="hidden" id="last_url" name="last_url" value="{{ $last_url }}">

        <div class="row py-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary me-2 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-secondary me-4 rounded-3" href="{{ url()->previous() }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
