@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <p class="rounded-3 px-2 culoare1 fs-5">
                    <i class="fas fa-music me-1"></i>{{ $piese->first()->categorie ?? '' }}
                </p>
            </div>
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('piese.index') }}">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-8 me-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        {{-- <input type="text" class="form-control form-control-sm col-md-4 me-1 border rounded-pill" id="search_artist" name="search_artist" placeholder="Artist" autofocus
                                value="{{ $search_artist }}"> --}}
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary col-md-4 me-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('piese.index') }}" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('piese.create') }}" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă piesă
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors.errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th class="text-white culoare2">Nr. Crt.</th>
                            <th class="text-white culoare2">Nume</th>
                            <th class="text-white culoare2">Artist</th>
                            <th class="text-white culoare2">Categorie</th>
                            <th class="text-white culoare2">Voturi</th>
                            <th class="text-white culoare2 text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($piese as $piesa)
                            <tr>
                                <td align="">
                                    {{ ($piese ->currentpage()-1) * $piese ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $piesa->nume }}</b>
                                </td>
                                <td>
                                    {{ $piesa->artist->nume ?? '' }}
                                </td>
                                <td>
                                    {{ $piesa->categorie }}
                                </td>
                                <td>
                                    {{ $piesa->voturi }}
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $piesa->path() }}"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-success">Vizualizează</span>
                                    </a>
                                    <a href="{{ $piesa->path() }}/modifica"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#stergePiesa{{ $piesa->id }}"
                                            title="Șterge Piesa"
                                            >
                                            <span class="badge bg-danger">Șterge</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$piese->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere piesa --}}
    @foreach ($piese as $piesa)
        <div class="modal fade text-dark" id="stergePiesa{{ $piesa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Piesa: <b>{{ $piesa->nume }}</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Piesa?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $piesa->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger"
                            >
                            Șterge Piesa
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
