@extends ('voteaza_si_propune.layout')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session()->has('status'))
                @include ('errors')
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-9 p-0">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="p-2"
                    style="
                        border-radius: 40px 40px 0px 0px;
                        border:5px solid #1a1a18;
                        color: #ffffff;
                        background-color:#1a1a18;
                    "
                >
                    <div class="row">
                        <div class="col-lg-12 py-0 text-center">
                            {{-- <h4 class="mb-4" style="color:#ffffff">
                                Tombolă
                                <br>
                                {{ session('inregistrareTombolaLaTop') }}
                            </h4>
                                Vă invităm să vă înregistrați la tombola Radio Dada. În urma înregistrării veți primi un cod, care va fi transmis și pe email.
                                <br>
                                Vom anunța codul câștigător în emisiune și va fi publicat și pe site-ul Radio Dada. --}}
                            @switch(session('inregistrareTombolaLaTop'))
                                @case("Cea mai 9 muzică bună")
                                    <img src="{{ url('/images/tombola/tombola-header-cea-mai-9-muzica-buna.jpg') }}" style="max-width: 100%; background-color:#1a1a18;">
                                    @break
                                @case("Românești de azi")
                                    <img src="{{ url('/images/tombola/tombola-header-romanesti-de-azi.jpg') }}" style="max-width: 100%; background-color:#1a1a18;">
                                    @break
                                @case("Cea mai bună muzică veche")
                                    <img src="{{ url('/images/tombola/tombola-header-cea-mai-buna-muzica-veche.jpg') }}" style="max-width: 100%; background-color:#1a1a18;">
                                    @break
                                @default
                            @endswitch
                        </div>
                    </div>
                </div>

                <div class="card-body py-2"
                    style="
                        color:rgb(0, 0, 0);
                        background-color:#ffffff;
                        border:5px solid #1a1a18;
                        border-radius: 0px 0px 0px 0px
                    "
                >

                    <div class="row">
                        <div class="col-lg-7 mb-2 mx-auto">
                            @if (!session()->has('status'))
                                @include ('errors')
                            @endif
                        </div>
                        <div class="col-lg-7 mx-auto">
                            <form  class="mb-0 needs-validation" novalidate method="POST" action="/voteaza-si-propune/inregistrare-tombola-pasul-1">
                                @csrf

                                <div class="row g-3 align-items-center mb-4">
                                    <div class="col-lg-3">
                                        <label for="nume" class="col-form-label py-0">Nume<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="nume" placeholder=""
                                            class="form-control rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                                            value="{{ old('nume') }}">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-4">
                                    <div class="col-lg-3">
                                        <label for="telefon" class="col-form-label py-0">Telefon<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="telefon" placeholder="Ex: 0749..."
                                            class="form-control rounded-3 {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                                            value="{{ old('telefon') }}">
                                        <small class="ps-3">
                                            * Numărul de telefon va fi verificat la înmânarea premiului.
                                        </small>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center mb-4">
                                    <div class="col-lg-3">
                                        <label for="email" class="col-form-label py-0">Email<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="email" placeholder=""
                                            class="form-control rounded-3 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-lg-12 border-start border-warning" style="border-width:5px !important"
                                    >
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input {{ $errors->has('gdpr') ? 'is-invalid' : '' }}" name="gdpr" id="gdpr" value="1" required
                                            {{ old('gdpr', ($programare->gdpr ?? "0")) === "1" ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gdpr">
                                                <span class="text-danger">*</span> Sunt de acord cu prelucrarea datelor mele personale în conformitate cu Regulamentul (UE) 2016-679 - privind protecţia persoanelor fizice în ceea ce priveşte
                                                prelucrarea datelor cu caracter personal şi privind libera circulaţie a acestor date şi de abrogare a Directivei 95/46/CE ale cărei prevederi le-am citit şi le cunosc.
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 py-2 justify-content-center">
                                    <div class="col-lg-6 py-2 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-lg btn-success me-3 rounded-3">
                                            Înregistrează
                                        </button>
                                        <a class="btn btn-lg btn-secondary rounded-3" href="/voteaza-si-propune/adauga">Renunță</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div style="
                        border-radius: 0px 0px 40px 40px;
                        border:5px solid #1a1a18;
                        color: #ffffff;
                        background-color:#1a1a18;
                    ">
                    <div class="row">
                        <div class="col-lg-12 py-0 text-center">
                            <img src="{{ url('/images/tombola/tombola-footer.jpg') }}" style="padding:0px 40px; max-width: 100%; background-color:#1a1a18;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
