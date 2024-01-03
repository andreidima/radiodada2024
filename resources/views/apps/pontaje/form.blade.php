@csrf

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px">
    <div class="col-lg-12 px-4 py-2 mb-0">
        <div class="row mb-0 justify-content-center">
            <div class="col-lg-4 mb-4">
                <label for="aplicatie_id" class="mb-0 ps-3">Aplicație<span class="text-danger">*</span></label>
                <select name="aplicatie_id" class="form-select bg-white rounded-3 {{ $errors->has('aplicatie_id') ? 'is-invalid' : '' }}">
                    <option selected></option>
                    @foreach ($aplicatii as $aplicatie)
                        <option value="{{ $aplicatie->id }}" {{ ($aplicatie->id === intval(old('aplicatie_id', $pontaj->actualizare->aplicatie_id ?? ''))) ? 'selected' : '' }}>{{ $aplicatie->nume }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-0 justify-content-center" id="TinyMCE">
            <div class="col-lg-12 mb-4">
                <label for="observatii" class="mb-0 ps-3">Observații:</label>
                <tinymce-vue
                    inputvalue="{{ old('observatii', $pontaj->observatii) }}"
                    height= 300
                    inputname="observatii"
                ></tinymce-vue>
            </div>
        </div>
    </div>

    <div class="col-lg-12 px-4 py-2 mb-0">
        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('actualizareReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
