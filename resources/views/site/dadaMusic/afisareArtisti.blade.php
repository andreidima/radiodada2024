@extends ('voteaza_si_propune.layout')

<script type="application/javascript">
    artisti = {!! json_encode($artisti) !!}
    propuneri = {!! json_encode($propuneri) !!}
</script>

@section('content')

<div class="container" id="artistAutocomplete">

    {{-- 1. The page displays the search and the gallery --}}
    {{-- 2. If there is an artist selected, the page display those artist informations --}}
    @if (!$artist)
        <div class="row justify-content-center">
            <div class="col-md-12 p-0">
                <div class="row mb-3 rounded-3" style="">
                    <div class="col-lg-12 mb-2 text-center" style="font-weight:bold">
                        Descoperă artiștii promovați de postul nostru de radio și piesele lor care s-au regăsit în topurile Dada de-a lungul timpului
                    </div>
                </div>
                <div class="row mb-3 rounded-3" style="">
                    <div class="col-lg-6 mb-2 mx-auto" style="position:relative;" v-click-out="() => artistiListaAutocomplete = ''">
                        <div v-on:focus="autocompleteArtisti();" class="input-group">
                            <input
                                type="text"
                                v-model="artist_nume"
                                v-on:focus="autocompleteArtisti();"
                                v-on:keyup="autocompleteArtisti();"
                                class="form-control bg-white rounded-3 {{ $errors->has('artist_nume') ? 'is-invalid' : '' }}"
                                name="artist_nume"
                                placeholder="search ARTIST"
                                autocomplete="off"
                                aria-describedby="artist_nume"
                                required
                                style="border:1px black solid"
                                >
                        </div>
                        <div v-cloak v-if="artistiListaAutocomplete && artistiListaAutocomplete.length" class="panel-footer">
                            <div class="list-group" style="max-height: 130px; overflow:auto;">
                                <div v-for="artist in artistiListaAutocomplete">
                                    <a class="list-group-item list-group-item list-group-item-action py-0" :href="'/site/dada-music/artisti/' + artist.id" style="text-decoration: none; color:black">
                                        @{{ artist.nume }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p-0">
                    <div class="w-100 mb-2 text-center">
                        @foreach ($artistiDeAfisatInGalerie as $artist)
                            @if ($artist->imagine)
                                <a href="{{ env('APP_URL') }}/site/dada-music/artisti/{{ $artist->id }}">
                                    <img class="rounded-3 m-2"
                                        src="{{ env('APP_URL') . $artist->imagine->imagine_cale . $artist->imagine->imagine_nume }}"
                                        title="{{ $artist->nume }}"
                                        style="
                                            width: 165px;
                                            height: 110px;
                                            object-fit: cover;
                                        "
                                        {{-- onerror="this.remove()" --}}
                                        >
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm justify-content-center">
                            {{$artistiDeAfisatInGalerie->appends(Request::except('page'))->links()}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <a class="mb-4 btn btn-danger rounded-3" href="{{ env('APP_URL') }}/site/dada-music/artisti" style="">
                    <b>
                        <i class="fa-solid fa-caret-left"></i>
                        back
                    </b>
                </a>

                <h4 class="m-0 mb-3 rounded-3 " style="font-weight:bold">
                    {{ $artist->nume }}
                </h4>

                @if ($artist->imagine)
                    <div class="w-100 mb-3 text-center">
                        <a href="{{ env('APP_URL') . $artist->imagine->imagine_cale . $artist->imagine->imagine_nume }}" target="_blank">
                            <img class="rounded-3" src="{{ env('APP_URL') . $artist->imagine->imagine_cale . $artist->imagine->imagine_nume }}" alt="" style="max-width: 100%">
                        </a>
                    </div>
                @endif

                <p class="m-0 mb-3 rounded-3" style="">
                    {{ $artist->descriere }}
                </p>

                <div v-if="afiseazaPropuneri" class="m-0 mb-4 rounded-3 px-3 text-center" style="">
                    <p class="m-0 rounded-3 py-0 px-2 text-center" style="">
                        PROPUNERI
                    </p>
                    @foreach ($propuneri as $propunere)
                        <p class="m-0 mb-3 rounded-3 px-2" style="">
                                @if ($propunere->link_youtube)
                                    <a href="{{ $propunere->link_youtube }}" target="_blank" style="text-decoration:none">
                                        {{ $propunere->nume }}
                                    </a>
                                @else
                                    {{ $propunere->nume }}
                                @endif
                        </p>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    @if ($artist->link)
                        <div class="mx-3">
                            <a href="{{ $artist->link }}" target="_blank" style="color: black">
                                <i class="fa-regular fa-user fa-3x"></i>
                            </a>
                        </div>
                    @endif
                    @if ($artist->magazin_virtual)
                        <div class="mx-3">
                            <a href="{{ $artist->magazin_virtual }}" target="_top" style="color: black">
                                <i class="fa-solid fa-cart-shopping fa-3x"></i>
                            </a>
                        </div>
                    @endif

                    @if ($propuneri->count() > 0)
                        <div class="mx-3">
                            <a
                                v-on:click="afiseazaPropuneri = !afiseazaPropuneri"
                            style="color: black">
                                <i class="fa-solid fa-headphones fa-3x"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif


</div>

@endsection
