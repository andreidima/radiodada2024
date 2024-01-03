@extends ('layouts.app')

@php
    use \Carbon\Carbon;
@endphp

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <span class="badge culoare1 fs-5">
                    <i class="fa-solid fa-clock me-1"></i>Pontaje
                </span>
            </div>
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ url()->current()  }}">
                    @csrf
                    <div class="row mb-1 custom-search-form justify-content-center">
                        <div class="col-lg-6">
                            <input type="text" class="form-control rounded-3" id="searchAplicatie" name="searchAplicatie" placeholder="Aplicație" value="{{ $searchAplicatie }}">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control rounded-3" id="searchActualizare" name="searchActualizare" placeholder="Actualizare" value="{{ $searchActualizare }}">
                        </div>
                    </div>
                    <div class="row custom-search-form justify-content-center">
                        <div class="col-lg-4">
                            <button class="btn btn-sm w-100 btn-primary text-white border border-dark rounded-3" type="submit">
                                <i class="fas fa-search text-white me-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-lg-4">
                            <a class="btn btn-sm w-100 btn-secondary text-white border border-dark rounded-3" href="{{ url()->current() }}" role="button">
                                <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm btn-success text-white border border-dark rounded-3 col-md-8" href="{{ url()->current() }}/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă pontaj
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors.errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover rounded">
                    <thead class="text-white rounded">
                        <tr class="thead-danger" style="padding:2rem">
                            <th class="text-white culoare2">#</th>
                            <th class="text-white culoare2">Aplicație</th>
                            <th class="text-white culoare2">Actualizare</th>
                            <th class="text-white culoare2">Data</th>
                            <th class="text-white culoare2">Timp</th>
                            <th class="text-white culoare2 text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pontaje as $pontaj)
                            <tr>
                                <td align="">
                                    {{ ($pontaje ->currentpage()-1) * $pontaje ->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="">
                                    {{ $pontaj->actualizare->aplicatie->nume ?? '' }}
                                </td>
                                <td class="">
                                    {{ $pontaj->actualizare->nume ?? '' }}
                                </td>
                                <td class="">
                                    {{ $pontaj->data ? Carbon::parse($pontaj->data)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                                <td class="">
                                    {{ $pontaj->timp ? Carbon::parse($pontaj->timp)->isoFormat('HH:mm') : '' }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $pontaj->path() }}" class="flex me-1">
                                            <span class="badge bg-success">Vizualizează</span>
                                        </a>
                                        <a href="{{ $pontaj->path() }}/modifica" class="flex me-1">
                                            <span class="badge bg-primary">Modifică</span>
                                        </a>
                                        <div style="flex" class="">
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#stergePontaj{{ $pontaj->id }}"
                                                title="Șterge Pontaj"
                                                >
                                                <span class="badge bg-danger">Șterge</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit înregistrări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$pontaje->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>
        </div>
    </div>

    {{-- Modalele pentru stergere pontaje --}}
    @foreach ($pontaje as $pontaj)
        <div class="modal fade text-dark" id="stergePontaj{{ $pontaj->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Pontaj: <b>{{ $pontaj->actualizare->aplicatie->nume ?? '' }} / {{ $pontaj->actualizare->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Pontajul?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $pontaj->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge pontajul
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
