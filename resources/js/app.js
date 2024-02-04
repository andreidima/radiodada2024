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

// App pentru DatePicker
const datePicker = createApp({});
datePicker.component('vue-datepicker-next', VueDatepickerNext);
if (document.getElementById('datePicker') != null) {
    datePicker.mount('#datePicker');
}

const app1 = createApp({
    el: '#app1',
    data() {
        return {
            international_piesa: '',
            international_trupa: '',
            international_titlu: '',
            international_imagine: typeof internationalImagineInitiala !== 'undefined' ? internationalImagineInitiala : '',
            international_descriere: '',
            international_link_youtube: '',
            international_link_interviu: '',
            international_magazin_virtual: '',
            romanesc_piesa: '',
            romanesc_trupa: '',
            romanesc_titlu: '',
            romanesc_imagine: typeof romanescImagineInitiala !== 'undefined' ? romanescImagineInitiala : '',
            romanesc_descriere: '',
            romanesc_link_youtube: '',
            romanesc_link_interviu: '',
            romanesc_magazin_virtual: '',
            veche_piesa: '',
            veche_trupa: '',
            veche_titlu: '',
            veche_imagine: typeof vecheImagineInitiala !== 'undefined' ? vecheImagineInitiala : '',
            veche_descriere: '',
            veche_link_youtube: '',
            veche_link_interviu: '',
            veche_magazin_virtual: '',

            top_incarcat: '',

            top_international_bg_color: 'bg-white',
            top_international_text_color: 'text-black',

            top_romanesc_bg_color: 'bg-white',
            top_romanesc_text_color: 'text-black',

            top_veche_bg_color: 'bg-white',
            top_veche_text_color: 'text-black'
        }
    },
    methods: {
        schimbaCuloare: function (value) {
            if (value == "top_international_danger") {
                this.top_international_bg_color = "bg-danger";
                this.top_international_text_color = "text-white";
            } else if (value == "top_international_white") {
                this.top_international_bg_color = "bg-white";
                this.top_international_text_color = "text-black";
            } else if (value == "top_romanesc_danger") {
                this.top_romanesc_bg_color = "bg-danger";
                this.top_romanesc_text_color = "text-white";
            } else if (value == "top_romanesc_white") {
                this.top_romanesc_bg_color = "bg-white";
                this.top_romanesc_text_color = "text-black";
            } else if (value == "top_veche_danger") {
                this.top_veche_bg_color = "bg-danger";
                this.top_veche_text_color = "text-white";
            } else if (value == "top_veche_white") {
                this.top_veche_bg_color = "bg-white";
                this.top_veche_text_color = "text-black";
            }
        }
    }
});
if (document.getElementById('app1') != null) {
    app1.mount('#app1');
}


