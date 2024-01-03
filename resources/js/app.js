/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

import '../sass/app.scss'
import '../css/andrei.css'

import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

// const app = createApp({});

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

import VueDatepickerNext from './components/DatePicker.vue';
import VueTinyMCE from './components/TinyMCE.vue';


// Click outside directive
const clickOutside = {
    beforeMount: (el, binding) => {
        el.clickOutsideEvent = event => {
            if (!(el == event.target || el.contains(event.target))) {
                binding.value();
            }
        };
        document.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted: el => {
        document.removeEventListener("click", el.clickOutsideEvent);
    },
};

// App pentru DatePicker
if (document.getElementById('datePicker') != null) {
    const datePicker = createApp({});
    datePicker.component('vue-datepicker-next', VueDatepickerNext);
    datePicker.mount('#datePicker');
}

// App pentru TinyMCE
if (document.getElementById('TinyMCE') != null) {
    const TinyMCE = createApp({});
    TinyMCE.component('tinymce-vue', VueTinyMCE);
    TinyMCE.mount('#TinyMCE');
}

// Folosita la Apps
const apps = createApp({
    el: '#apps',
    data() {
        return {
            aplicatie_id: ((typeof aplicatieIdVechi !== 'undefined') ? aplicatieIdVechi : ''),
            aplicatie_nume: '',
            aplicatii: ((typeof aplicatii !== 'undefined') ? aplicatii : []),
            aplicatiiListaAutocomplete: [],

            arataCampActualizari: false,
            actualizare_id: ((typeof actualizareIdVechi !== 'undefined') ? actualizareIdVechi : ''),
            actualizare_nume: '',
            actualizari: [],
            actualizariListaAutocomplete: [],
        }
    },
    watch: {
        aplicatie_id: function () {
            console.log(this.aplicatie_id);
            this.actualizare_id = '';
            this.actualizare_nume = '';
            this.actualizari = [];
        }
    },
    created: function () {
        if (this.aplicatie_id) {
            for (var i = 0; i < this.aplicatii.length; i++) {
                if (this.aplicatii[i].id == this.aplicatie_id) {
                    this.aplicatie_nume = this.aplicatii[i].nume;
                    break;
                }
            }
        }

        this.axiosCautaActualizari();
    },
    methods: {
        autocompleteAplicatii() {
            this.aplicatiiListaAutocomplete = [];
            for (var i = 0; i < this.aplicatii.length; i++) {
                if (this.aplicatii[i].nume) {
                    if (this.aplicatii[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.aplicatie_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                        this.aplicatiiListaAutocomplete.push(this.aplicatii[i]);
                    }
                }
            }
        },
        axiosCautaActualizari() {
            this.actualizari = [];
            this.arataCampActualizari = false;
            axios.get('/apps/actualizari/axios', {
                    params: {
                        aplicatie_id: this.aplicatie_id,
                    }
                })
                .then(
                    response => {
                        this.actualizari = response.data.actualizari;

                        if (this.actualizare_id) {
                            for (var i = 0; i < this.actualizari.length; i++) {
                                if (this.actualizari[i].id == this.actualizare_id) {
                                    this.actualizare_nume = this.actualizari[i].nume;
                                    break;
                                }
                            }
                        }
                        this.arataCampActualizari = true;

                    }
            );
        },
        autocompleteActualizari() {
            this.actualizariListaAutocomplete = [];
            for (var i = 0; i < this.actualizari.length; i++) {
                if (this.actualizari[i].nume) {
                    if (this.actualizari[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.actualizare_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                        this.actualizariListaAutocomplete.push(this.actualizari[i]);
                    }
                }
            }
        },
    }
});
apps.directive("clickOut", clickOutside);
if (document.getElementById('apps') != null) {
    apps.mount('#apps');
}


