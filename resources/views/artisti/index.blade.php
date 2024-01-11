@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <span class="badge culoare1 fs-5">
                    <i class="fas fa-users me-1"></i>Artiști</a>
                </span>
            </div>
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('artisti.index') }}">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-8 me-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary col-md-4 me-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('artisti.index') }}" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('artisti.create') }}" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă artist
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
                            <th class="text-white culoare2 text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($artisti as $artist)
                            <tr>
                                <td align="">
                                    {{ ($artisti ->currentpage()-1) * $artisti ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $artist->nume }}</b>
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $artist->path() }}"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-success">Vizualizează</span>
                                    </a>
                                    <a href="{{ $artist->path() }}/modifica"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeArtist{{ $artist->id }}"
                                            title="Șterge Artist"
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
                        {{$artisti->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere artist --}}
    @foreach ($artisti as $artist)
        <div class="modal fade text-dark" id="stergeArtist{{ $artist->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Artist: <b>{{ $artist->titlu }}</b></h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Artistul?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $artist->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger"
                            >
                            Șterge Artist
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
