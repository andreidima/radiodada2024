@csrf

<div class="row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="col-lg-12 px-2 mb-0">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <label for="nume" class="mb-0 pl-3">Nume:*</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $piesa->nume) }}"
                    required>
            </div>
            <div class="col-lg-12 mb-4">

                    <label for="artist_id" class="mb-0 pl-3">Artist:</label>
                    <div class="">
                        <select name="artist_id"
                            class="form-select bg-white rounded-pill {{ $errors->has('artist_id') ? 'is-invalid' : '' }}"
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
                <label for="categorie" class="mb-0 pl-3">Categorie:*</label>
                <select name="categorie" class="form-select bg-white rounded-pill {{ $errors->has('client_deja_inregistrat') ? 'is-invalid' : '' }}">
                    <option value="">Selectează categorie</option>
                    <option value="Top" {{ (old('categorie', $piesa->categorie) == "Top") ? 'selected' : '' }}>Top</option>
                    <option value="Propunere" {{ (old('categorie', $piesa->categorie) == "Propunere") ? 'selected' : '' }}>Propunere</option>
                </select>
            </div>
        </div>

        <div class="row py-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm me-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm me-4 rounded-pill" href="{{ $client_neserios->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm me-4 rounded-pill" href="/piese">Renunță</a>
            </div>
        </div>
    </div>
</div>
