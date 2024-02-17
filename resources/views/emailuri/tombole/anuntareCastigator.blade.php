<div style="margin:0 auto;width:100%; background-color:#eff1f0;">
    <div style="margin:0 auto; max-width:800px!important; background-color: white;">

        @include ('emailuri.headerFooter.header')

        <div style="padding:20px 20px; max-width:760px!important;margin:0 auto; font-size:18px">
            Bună dimineața {{ $tombola->nume }},
            <br>
            <h2>FELICITĂRI</h2>

            Tichetul tău <b>{{ $tombola->cod }}</b> la topul „{{ $tombola->top }}” a ieșit câștigător la extragerea de săptămâna trecută.
            <br><br>
            Te rugăm să ne trimiți un mesaj pe <b>Whatsapp 0722.100.670</b>, folosind telefonul cu care te-ai înregistrat, în care să menționezi:
            <br>
            <b>Mărimea tricoului: __________________</b>
            <br>
            <b>Adresa la care trebuie trimis tricoul: _____________________________________________</b>
            <br><br>
            Tricoul se trimite prin courier. Durata de producție a tricoului este de 7 zile lucrătoare.
            <br><br>
            Îți dorim o săptămână perfectă.


            <br><br><br>
            Acesta este un mesaj automat. Te rugăm să nu răspunzi la acest e-mail.
            <br><br>
            Mulțumim!
        </div>
    </div>

    @include ('emailuri.headerFooter.footer')
</div>

