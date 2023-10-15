@csrf

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px">
    <div class="col-lg-12 px-4 py-2 mb-0">
        <div class="row mb-0 justify-content-center">
            <div class="col-lg-6 mb-4">
                <label for="nume" class="mb-0 ps-3">Nume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    value="{{ old('nume', $aplicatie->nume) }}">
            </div>
            <div class="col-lg-6 mb-4">
                <label for="local_url" class="mb-0 ps-3">Local url</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('local_url') ? 'is-invalid' : '' }}"
                    name="local_url"
                    value="{{ old('local_url', $aplicatie->local_url) }}">
            </div>
            <div class="col-lg-6 mb-4">
                <label for="online_url" class="mb-0 ps-3">Online url</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('online_url') ? 'is-invalid' : '' }}"
                    name="online_url"
                    value="{{ old('online_url', $aplicatie->online_url) }}">
            </div>
            <div class="col-lg-6 mb-4">
                <label for="github_url" class="mb-0 ps-3">Github url</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('github_url') ? 'is-invalid' : '' }}"
                    name="github_url"
                    value="{{ old('github_url', $aplicatie->github_url) }}">
            </div>
        </div>
    </div>

    <div class="col-lg-12 px-4 py-2 mb-0">
        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('aplicatieReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
