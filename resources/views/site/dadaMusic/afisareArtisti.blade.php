@extends ('voteaza_si_propune.layout')

<script type="application/javascript">
    artisti = {!! json_encode($artisti) !!}
    propuneri = {!! json_encode($propuneri) !!}
</script>

@section('content')

<div class="container">

    <div class="row justify-content-center" id="artistAutocomplete">
        <div class="col-md-12 p-0">
            <form class="needs-validation" novalidate method="GET" action="{{ url()->current() }}">
                @csrf
                <div class="mb-1 input-group custom-search-form justify-content-center">
                    {{-- <input type="text" class="form-control" id="search_nume" name="search_nume" placeholder="caută ARTIST" autofocus
                            value="{{ $search_nume }}" aria-describedby="searchNume"> --}}
                    {{-- <button class="btn btn-outline-secondary" type="button" id="searchNume">Caută</button> --}}
                </div>

                {{-- <div class="input-group mb-3">
  <button class="btn btn-outline-secondary" type="button" id="button-addon1">Button</button>
  <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
</div> --}}

                {{-- <div class="row input-group custom-search-form justify-content-center">
                    <button class="btn btn-sm btn-primary col-md-4 me-1 border border-dark rounded-pill" type="submit">
                        <i class="fas fa-search text-white me-1"></i>Caută
                    </button>
                    <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ url()->current() }}" role="button">
                        <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                    </a>
                </div> --}}
            </form>


        <div class="row mb-4 pt-2 rounded-3" style="">
            <div class="col-lg-12 mb-2" style="position:relative;" v-click-out="() => artistiListaAutocomplete = ''">
                <div v-on:focus="autocompleteArtisti();" class="input-group">
                    <input
                        type="text"
                        v-model="artist_nume"
                        v-on:focus="autocompleteArtisti();"
                        v-on:keyup="autocompleteArtisti();"
                        class="form-control bg-white rounded-3 {{ $errors->has('artist_nume') ? 'is-invalid' : '' }}"
                        name="artist_nume"
                        placeholder="caută ARTIST"
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

        @if ($artist)
            <div class="row">
                <div class="col-lg-12">
                    <p class="m-0 mb-3 rounded-3 px-2" style="background-color: gainsboro">{{ $artist->nume }}</p>

                    @if ($artist->imagine)
                        <div class="w-100 mb-3 text-center">
                            <a href="{{ env('APP_URL') . $artist->imagine->imagine_cale . $artist->imagine->imagine_nume }}" target="_blank">
                                <img class="rounded-3" src="{{ env('APP_URL') . $artist->imagine->imagine_cale . $artist->imagine->imagine_nume }}" alt="" style="max-width: 100%">
                            </a>
                        </div>
                    @endif

                    <p class="m-0 mb-3 rounded-3 px-2" style="background-color: gainsboro">
                        {{ $artist->descriere }}
                    </p>

                    <div v-if="afiseazaPropuneri" class="m-0 mb-3 rounded-3 px-2 text-center" style="background-color: gainsboro">
                        <p class="m-0 rounded-3 px-2 text-center" style="background-color: gainsboro">
                            PROPUNERI
                        </p>
                        @foreach ($propuneri as $propunere)
                            <p class="m-0 mb-3 rounded-3 px-2" style="background-color: gainsboro">
                                {{ $propunere->nume }}
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
                                <a href="{{ $artist->magazin_virtual }}" style="color: black">
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


</div>

@endsection
