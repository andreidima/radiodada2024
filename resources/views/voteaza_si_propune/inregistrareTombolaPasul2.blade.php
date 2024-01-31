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
                        <div class="col-lg-12 text-center">
                            @switch($tombola->top)
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
                            {{-- <h4 class="mb-0" style="color:#ffffff">
                                Tombolă
                                <br>
                                {{ $tombola->top }}
                            </h4> --}}
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

                    <div class="row justify-content-center">
                        <div class="col-lg-7 mb-2">
                            @if (!session()->has('status'))
                                @include ('errors')
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <div class="row mb-4">
                                <div class="col-lg-12 text-center">
                                    Mulțumim pentru înregistrare!
                                    <br>
                                    Codul tău este <span style="font-weight: bold; font-size:200%">{{ $tombola->cod }}</span>
                                    {{-- <br>
                                    Îți poți nota acest cod, dar pentru siguranță, noi ți l-am trimis și pe email.
                                    <br>
                                    Vom anunța codul câștigător în emisiune și va fi publicat și pe site-ul Radio Dada. --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 py-0">
                            <div class="row g-2 mx-4 p-3 rounded-3 align-items-center mb-4 text-dark" style="background-color: #e4e4e4">
                                <div class="col-lg-3">
                                    <label for="nume" class="col-form-label py-0">Nume</label>
                                </div>
                                <div class="col-lg-9">
                                    <label for="nume" class="col-form-label py-0">{{ $tombola->nume }}</label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="telefon" class="col-form-label py-0">Telefon</label>
                                </div>
                                <div class="col-lg-9">
                                    <label for="telefon" class="col-form-label py-0">{{ $tombola->telefon }}</label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="email" class="col-form-label py-0">Email</label>
                                </div>
                                <div class="col-lg-9">
                                    <label for="email" class="col-form-label py-0">{{ $tombola->email }}</label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-lg-12">
                            <div class="row g-3 justify-content-center mb-4">
                                <div class="col-lg-12 text-center">
                                    * Numărul de telefon va fi verificat la înmânarea premiului.
                                    <br>
                                    ** Te poți înregistra și la celelalte topuri dacă dorești.
                                    Fiecare top are câte o tombolă săptămânală.
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-lg-12">
                            <div class="row g-3 justify-content-center">
                                <div class="col-lg-6 py-2 d-flex justify-content-center">
                                    <a class="btn btn-lg btn-primary rounded-3" href="/voteaza-si-propune/adauga">Revino la topuri</a>
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
