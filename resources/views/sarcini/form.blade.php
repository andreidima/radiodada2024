@csrf

@php
    use \Carbon\Carbon;
@endphp

<script type="application/javascript">
    aplicatii = {!! json_encode($aplicatii) !!}
    aplicatieIdVechi = {!! json_encode(old('aplicatie_id', ($pontaj->actualizare->aplicatie_id ?? "")) ?? "") !!}
    actualizareIdVechi = {!! json_encode(old('actualizare_id', ($pontaj->actualizare_id ?? "")) ?? "") !!}
</script>

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px">
    <div class="col-lg-12 px-4 py-2 mb-0">

        {{-- On enter key, first form submit button will be used --}}
        <input type="submit" aria-hidden="true" tabindex="-1" style="height: 0; visibility: hidden;" />

        <div class="row justify-content-center" id="apps">
            <div class="col-lg-4 mb-4" style="position:relative;" v-click-out="() => aplicatiiListaAutocomplete = ''">
                <label for="aplicatie_id" class="mb-0 ps-3">Aplicație<span class="text-danger">*</span></label>
                <input
                    type="hidden"
                    v-model="aplicatie_id"
                    name="aplicatie_id">

                <div v-on:focus="autocompleteAplicatii();" class="input-group">
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="!aplicatie_id" class="input-group-text" id="aplicatie_nume">?</span>
                        <span v-if="aplicatie_id" class="input-group-text bg-success text-white" id="aplicatie_nume"><i class="fa-solid fa-check"></i></span>
                    </div>
                    <input
                        type="text"
                        v-model="aplicatie_nume"
                        v-on:focus="autocompleteAplicatii();"
                        v-on:keyup="autocompleteAplicatii(); this.aplicatie_id = '';"
                        class="form-control bg-white rounded-3 {{ $errors->has('aplicatie_nume') ? 'is-invalid' : '' }}"
                        name="aplicatie_nume"
                        placeholder=""
                        autocomplete="off"
                        aria-describedby="aplicatie_nume"
                        required>
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="aplicatie_id" class="input-group-text text-danger" id="aplicatie_nume" v-on:click="aplicatie_id = null; aplicatie_nume = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                    <div class="input-group-prepend ms-2 d-flex align-items-center">
                        <button type="submit" ref="submit" formaction="/apps/pontaje/adauga-resursa/aplicatie" class="btn btn-success text-white rounded-3 py-0 px-2"
                            style="font-size: 30px; line-height: 1.2;" title="Adaugă aplicatie nouă">+</button>
                    </div>
                </div>
                <div v-cloak v-if="aplicatiiListaAutocomplete && aplicatiiListaAutocomplete.length" class="panel-footer">
                    <div class="list-group" style="max-height: 130px; overflow:auto;">
                        <button class="list-group-item list-group-item list-group-item-action py-0"
                            v-for="aplicatie in aplicatiiListaAutocomplete"
                            v-on:click="
                                aplicatie_id = aplicatie.id;
                                aplicatie_nume = aplicatie.nume;

                                aplicatiiListaAutocomplete = ''
                                axiosCautaActualizari();
                            ">
                                @{{ aplicatie.nume }}
                        </button>
                    </div>
                </div>
                {{-- <small v-if="!aplicatie_id" class="ps-3">* Selectați o aplicație</small>
                <small v-else class="ps-3 text-success">* Ați selectat aplicația</small> --}}
            </div>
            <div class="col-lg-4 mb-4" style="position:relative;" v-click-out="() => actualizariListaAutocomplete = ''">
                <label for="actualizare_id" class="mb-0 ps-3">Actualizare<span class="text-danger">*</span></label>
                <input
                    type="hidden"
                    v-model="actualizare_id"
                    name="actualizare_id">

                <div v-if="arataCampActualizari" v-on:focus="autocompleteActualizari();" class="input-group">
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="!actualizare_id" class="input-group-text" id="actualizare_nume">?</span>
                        <span v-if="actualizare_id" class="input-group-text bg-success text-white" id="actualizare_nume"><i class="fa-solid fa-check"></i></span>
                    </div>
                    <input
                        type="text"
                        v-model="actualizare_nume"
                        v-on:focus="autocompleteActualizari();"
                        v-on:keyup="autocompleteActualizari(); this.actualizare_id = '';"
                        class="form-control bg-white rounded-3 {{ $errors->has('actualizare_nume') ? 'is-invalid' : '' }}"
                        name="actualizare_nume"
                        placeholder=""
                        autocomplete="off"
                        aria-describedby="actualizare_nume"
                        required>
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="actualizare_id" class="input-group-text text-danger" id="actualizare_nume" v-on:click="actualizare_id = null; actualizare_nume = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                    <div class="input-group-prepend ms-2 d-flex align-items-center">
                        <button type="submit" ref="submit" formaction="/apps/pontaje/adauga-resursa/actualizare" class="btn btn-success text-white rounded-3 py-0 px-2"
                            style="font-size: 30px; line-height: 1.2;" title="Adaugă actualizare nouă">+</button>
                    </div>
                </div>
                <div v-cloak v-if="actualizariListaAutocomplete && actualizariListaAutocomplete.length" class="panel-footer">
                    <div class="list-group" style="max-height: 130px; overflow:auto;">
                        <button class="list-group-item list-group-item list-group-item-action py-0"
                            v-for="actualizare in actualizariListaAutocomplete"
                            v-on:click="
                                actualizare_id = actualizare.id;
                                actualizare_nume = actualizare.nume;

                                actualizariListaAutocomplete = ''
                                axiosCautaActualizari();
                            ">
                                @{{ actualizare.nume }}
                        </button>
                    </div>
                </div>
                {{-- <small v-if="!actualizare_id" class="ps-3">* Selectați o actualizare</small>
                <small v-else class="ps-3 text-success">* Ați selectat actualizarea</small> --}}
            </div>
        </div>
        <div class="row justify-content-center" id="datePicker">
            <div class="col-lg-2 mb-4 text-center">
                <label for="inceput" class="mb-0 ps-0">Început<span class="text-danger">*</span></label>
                <vue-datepicker-next
                    data-veche="{{ old('inceput', $pontaj->inceput ?? Carbon::now()) }}"
                    nume-camp-db="inceput"
                    tip="datetime"
                    value-type="YYYY-MM-DD HH:mm"
                    format="DD.MM.YYYY HH:mm"
                    :latime="{ width: '160px' }"
                ></vue-datepicker-next>
            </div>
            <div class="col-lg-2 mb-4 text-center">
                <label for="sfarsit" class="mb-0 ps-0">Sfârșit</label>
                <vue-datepicker-next
                    data-veche="{{ old('sfarsit', $pontaj->sfarsit) }}"
                    nume-camp-db="sfarsit"
                    tip="datetime"
                    value-type="YYYY-MM-DD HH:mm"
                    format="DD.MM.YYYY HH:mm"
                    :latime="{ width: '160px' }"
                ></vue-datepicker-next>
            </div>
        </div>
    </div>

    <div class="col-lg-12 px-4 py-2 mb-0">
        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('pontajReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
