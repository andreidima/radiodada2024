@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-4 my-0" style="color:white"><i class="fas fa-music me-1"></i>Piese / {{ $piesa->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

            @include ('errors.errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        >
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $piesa->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Artist
                                </td>
                                <td>
                                    {{ $piesa->artist->nume ?? '' }}
                                </td>
                            </tr>
                                <td>
                                    Link Youtube
                                </td>
                                <td>
                                    {{ $piesa->link_youtube }}
                                </td>
                            </tr>
                                <td>
                                    Link interviu
                                </td>
                                <td>
                                    {{ $piesa->link_interviu }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Categorie
                                </td>
                                <td>
                                    {{ $piesa->categorie }}
                                </td>
                            </tr>
                            </tr>
                                <td>
                                    Voturi
                                </td>
                                <td>
                                    {{ $piesa->voturi }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary rounded-pill" href="{{ url()->previous() }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
