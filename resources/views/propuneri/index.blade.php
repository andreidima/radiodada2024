@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <span class="badge culoare1 fs-5">
                    <i class="fas fa-list-alt me-1"></i>Propuneri
                </span>
            </div>
            <div class="col-lg-6">
            </div>
            <div class="col-lg-3 text-end">
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors.errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Top</th>
                            <th>Data</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($propuneri as $propunere)
                            <tr>
                                <td align="">
                                    {{ ($propuneri ->currentpage()-1) * $propuneri ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $propunere->nume }}
                                </td>
                                <td>
                                    {{ $propunere->top }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($propunere->created_at)->isoFormat('DD.MM.YYYY') }}
                                </td>
                                <td class="d-flex justify-content-end">
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#stergePropunere{{ $propunere->id }}"
                                            title="Șterge Propunere"
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
                        {{$propuneri->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere propunere --}}
    @foreach ($propuneri as $propunere)
        <div class="modal fade text-dark" id="stergePropunere{{ $propunere->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Propunere: <b>{{ $propunere->titlu }}</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Propunerea?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $propunere->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger"
                            >
                            Șterge Propunere
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
