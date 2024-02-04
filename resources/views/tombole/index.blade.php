@extends ('layouts.app')

@php
    use \Carbon\Carbon;
@endphp

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <span class="badge culoare1 fs-5">
                    <i class="fa-solid fa-bars me-1"></i>Tombole
                </span>
            </div>
            <div class="col-lg-10">
                <form class="needs-validation" novalidate method="GET" action="{{ url()->current() }}">
                    @csrf
                    <div class="row mb-1 custom-search-form justify-content-center">
                        <div class="col-lg-2">
                            <input type="text" class="form-control rounded-3" id="searchNume" name="searchNume" placeholder="Nume" value="{{ $searchNume }}">
                        </div>
                        <div class="col-lg-2">
                            <input type="text" class="form-control rounded-3" id="searchTelefon" name="searchTelefon" placeholder="Telefon" value="{{ $searchTelefon }}">
                        </div>
                        <div class="col-lg-3">
                            <select name="searchTop" class="form-select bg-white rounded-3 {{ $errors->has('searchTop') ? 'is-invalid' : '' }}">
                                <option selected value="" style="color:white; background-color: gray;">Top</option>
                                <option value="Cea mai 9 muzică bună" {{ $searchTop == "Cea mai 9 muzică bună" ? 'selected' : '' }}>Cea mai 9 muzică bună</option>
                                <option value="Românești de azi" {{ $searchTop == "Românești de azi" ? 'selected' : '' }}>Românești de azi</option>
                                <option value="Cea mai bună muzică veche" {{ $searchTop == "Cea mai bună muzică veche" ? 'selected' : '' }}>Cea mai bună muzică veche</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select name="searchCastigator" class="form-select bg-white rounded-3 {{ $errors->has('searchCastigator') ? 'is-invalid' : '' }}">
                                <option selected value="" style="color:white; background-color: gray;">Câștigător</option>
                                <option value="1" {{ $searchCastigator == "1" ? 'selected' : '' }}>DA</option>
                                <option value="0" {{ $searchCastigator == "0" ? 'selected' : '' }}>NU</option>
                            </select>
                        </div>
                        <div class="col-lg-3 d-flex align-items-center" id="datePicker">
                            <label for="searchInterval" class="pe-1">Interval:</label>
                            <vue-datepicker-next
                                data-veche="{{ $searchInterval }}"
                                nume-camp-db="searchInterval"
                                tip="date"
                                range="range"
                                value-type="YYYY-MM-DD"
                                format="DD.MM.YYYY"
                                :latime="{ width: '210px' }"
                            ></vue-datepicker-next>
                        </div>
                    </div>
                    <div class="row custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm btn-secondary text-white col-md-4 border border-dark rounded-3" href="{{ url()->current() }}" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover">
                    <thead class="">
                        <tr class="" style="padding:2rem">
                            <th class="text-white culoare2">#</th>
                            <th class="text-white culoare2">Nume</th>
                            <th class="text-white culoare2">Telefon</th>
                            <th class="text-white culoare2">Email</th>
                            <th class="text-white culoare2">Top</th>
                            <th class="text-white culoare2">Data</th>
                            <th class="text-white culoare2">Cod</th>
                            <th class="text-white culoare2">Câștigător</th>
                            <th class="text-white culoare2 text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tombole as $tombola)
                            <tr>
                                <td align="">
                                    {{ ($tombole ->currentpage()-1) * $tombole ->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="">
                                    {{ $tombola->nume }}
                                </td>
                                <td class="">
                                    {{ $tombola->telefon }}
                                </td>
                                <td class="">
                                    {{ $tombola->email }}
                                </td>
                                <td class="">
                                    {{ $tombola->top }}
                                </td>
                                <td class="">
                                    {{ $tombola->created_at ? Carbon::parse($tombola->created_at)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                                <td class="">
                                    {{ $tombola->cod }}
                                </td>
                                <td class="">
                                    @if ($tombola->castigator == "1")
                                        <span class="text-success">DA</span>
                                    @elseif ($tombola->castigator == "0")
                                        <span class="text-danger">NU</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="flex" class="text-end">
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeTombola{{ $tombola->id }}"
                                            title="Șterge Tombola"
                                            >
                                            <span class="badge bg-danger">Șterge</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{ $tombole->appends(Request::except('page'))->links() }}
                    </ul>
                </nav>
        </div>
    </div>

    {{-- Modalele pentru stergere tombola --}}
    @foreach ($tombole as $tombola)
        <div class="modal fade text-dark" id="stergeTombola{{ $tombola->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Participant: <b>{{ $tombola->nume }}</b></h5>
                    <button type="button" class="close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Participantul?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $tombola->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger"
                            >
                            Șterge Participant
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
