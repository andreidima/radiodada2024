<?php

namespace App\Http\Controllers;

use App\Models\Piesa;
use App\Models\Propunere;
use App\Models\Tombola;
use App\Models\Variabila;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class VoteazaPropuneController extends Controller
{
    public function verificareSistemDeOperare()
    {
        echo $_SERVER['HTTP_USER_AGENT'];
        echo '<br><br>';
        if (stripos($_SERVER['HTTP_USER_AGENT'],"Android") || stripos($_SERVER['HTTP_USER_AGENT'],"Windows")){
            // dd('win');
            return redirect('/voteaza-si-propune/adauga');
            // $this->create();
            // deschide in Iframe
        } else {
            // echo "<script>window.open('https://www.radiodada.ro/voteaza-si-propune/adauga', '_blank')</script>";
        }
    }


    /**
     * Formular de votare piesa sau propunere piesa
     */
    public function create()
    {
        session()->forget('inregistrareTombolaLaTop'); // cheie pentru pasul 1 unde se face inregistrarea
        session()->forget('tombola'); // modelul transmis de la pasul 1 la pasul 2

        $piese = Piesa::with('artist')->orderByDesc('voturi')->get();

        $coduriCastigatoareSaptamanaTrecuta = Tombola::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->where('castigator', 1)->get();

        return view('voteaza_si_propune.create', compact('piese', 'coduriCastigatoareSaptamanaTrecuta'));
    }


    /**
     * Salvează votarea piesei sau piesa propusa
     */
    public function store(Request $request)
    {
        switch ($request->input('action')) {
            case 'top_international_voteaza':
                if ($request->session()->has('top_international_votat_deja_variabila_sesiune')) {
                    return back()->with('top_international_votat_deja', 'Ai votat deja o piesă din acest top. La fiecare top poți vota o singură dată pe zi.');
                } else {
                    request()->validate(
                        ['top_international_piesa' => 'required|integer'],
                        ['top_international_piesa.required' => 'Selectează piesa pe care dorești să o votezi.']
                    );

                    $piesa = Piesa::find($request->top_international_piesa);
                    $piesa->voturi ++ ;
                    $piesa->save();

                    $request->session()->put('top_international_votat_deja_variabila_sesiune', 'da');

                    // return back()->with('top_international_votat', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');
                    $request->session()->put('inregistrareTombolaLaTop', 'Cea mai 9 muzică bună');
                    return redirect('/voteaza-si-propune/inregistrare-tombola-pasul-1')->with('status', 'Votul dumneavoastră a fost inregistrat!');
                }
                break;

            case 'top_international_propunere':
                // if ($request->top_international_propunere == "12345") {
                //     $request->session()->put('inregistrareTombolaLaTop', 'Cea mai 9 muzică bună');
                //     return redirect('/voteaza-si-propune/inregistrare-tombola-pasul-1')->with('status', 'Votul dumneavoastră a fost inregistrat!');
                // }

                if ($request->session()->has('top_international_propus_deja_variabila_sesiune')) {
                    return back()->with('top_international_propus_deja', 'Ai propus deja o piesă pentru acest top. Poți propune o singură dată.');
                } else {
                    request()->validate(
                        ['top_international_propunere' => 'required|max:500'],
                        [
                            'top_international_propunere.required' => 'Completează piesa pe care dorești sa o propui.',
                            'top_international_propunere.max:500' => 'Poți introduce cel mult 500 de caractere.',
                        ]
                    );
                    $propunere = new Propunere;
                    $propunere->nume = $request->top_international_propunere;
                    $propunere->top = 'Top International';
                    $propunere->save();

                    $request->session()->put('top_international_propus_deja_variabila_sesiune', 'da');

                    return back()->with('top_international_propus', 'Ai propus piesa „' . $propunere->nume . '” pentru topul „Cea mai 9 muzică bună”!');
                }
                break;
            case 'top_romanesc_voteaza':
                if ($request->session()->has('top_romanesc_votat_deja_variabila_sesiune')) {
                    return back()->with('top_romanesc_votat_deja', 'Ai votat deja o piesă din acest top. La fiecare top poți vota o singură dată pe zi.');
                } else {
                    request()->validate(
                        ['top_romanesc_piesa' => 'required|integer'],
                        ['top_romanesc_piesa.required' => 'Selectează piesa pe care dorești să o votezi.']
                    );

                    $piesa = Piesa::find($request->top_romanesc_piesa);
                    $piesa->voturi ++ ;
                    $piesa->save();

                    $request->session()->put('top_romanesc_votat_deja_variabila_sesiune', 'da');

                    // return back()->with('top_romanesc_votat', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');
                    $request->session()->put('inregistrareTombolaLaTop', 'Românești de azi');
                    return redirect('/voteaza-si-propune/inregistrare-tombola-pasul-1')->with('status', 'Votul dumneavoastră a fost inregistrat!');
                }
                break;

            case 'top_romanesc_propunere':
                // if ($request->top_romanesc_propunere == "12345") {
                //     $request->session()->put('inregistrareTombolaLaTop', 'Românești de azi');
                //     return redirect('/voteaza-si-propune/inregistrare-tombola-pasul-1')->with('status', 'Votul dumneavoastră a fost inregistrat!');
                // }

                if ($request->session()->has('top_romanesc_propus_deja_variabila_sesiune')) {
                    return back()->with('top_romanesc_propus_deja', 'Ai propus deja o piesă pentru acest top. Poți propune o singură dată.');
                } else {
                    request()->validate(
                        ['top_romanesc_propunere' => 'required|max:500'],
                        [
                            'top_romanesc_propunere.required' => 'Completează piesa pe care dorești sa o propui.',
                            'top_romanesc_propunere.max:500' => 'Poți introduce cel mult 500 de caractere.',
                        ]
                    );
                    $propunere = new Propunere;
                    $propunere->nume = $request->top_romanesc_propunere;
                    $propunere->top = 'Top Romanesc';
                    $propunere->save();

                    $request->session()->put('top_romanesc_propus_deja_variabila_sesiune', 'da');

                    return back()->with('top_romanesc_propus', 'Ai propus piesa „' . $propunere->nume . '” pentru topul „Românești de azi”!');
                }
                break;

            case 'top_veche_voteaza':
                if ($request->session()->has('top_veche_votat_deja_variabila_sesiune')) {
                    return back()->with('top_veche_votat_deja', 'Ai votat deja o piesă din acest top. La fiecare top poți vota o singură dată pe zi.');
                } else {
                    request()->validate(
                        ['top_veche_piesa' => 'required|integer'],
                        ['top_veche_piesa.required' => 'Selectează piesa pe care dorești să o votezi.']
                    );

                    $piesa = Piesa::find($request->top_veche_piesa);
                    $piesa->voturi ++ ;
                    $piesa->save();

                    $request->session()->put('top_veche_votat_deja_variabila_sesiune', 'da');

                    // return back()->with('top_veche_votat', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');
                    $request->session()->put('inregistrareTombolaLaTop', 'Cea mai bună muzică veche');
                    return redirect('/voteaza-si-propune/inregistrare-tombola-pasul-1')->with('status', 'Votul dumneavoastră a fost inregistrat!');
                }
                break;

            case 'top_veche_propunere':
                // if ($request->top_veche_propunere == "12345") {
                //     $request->session()->put('inregistrareTombolaLaTop', 'Cea mai bună muzică veche');
                //     return redirect('/voteaza-si-propune/inregistrare-tombola-pasul-1')->with('status', 'Votul dumneavoastră a fost inregistrat!');
                // }

                if ($request->session()->has('top_veche_propus_deja_variabila_sesiune')) {
                    return back()->with('top_veche_propus_deja', 'Ai propus deja o piesă pentru acest top. Poți propune o singură dată.');
                } else {
                    request()->validate(
                        ['top_veche_propunere' => 'required|max:500'],
                        [
                            'top_veche_propunere.required' => 'Completează piesa pe care dorești sa o propui.',
                            'top_veche_propunere.max:500' => 'Poți introduce cel mult 500 de caractere.',
                        ]
                    );
                    $propunere = new Propunere;
                    $propunere->nume = $request->top_veche_propunere;
                    $propunere->top = 'Cea mai bună muzică veche';
                    $propunere->save();

                    $request->session()->put('top_veche_propus_deja_variabila_sesiune', 'da');

                    return back()->with('top_veche_propus', 'Ai propus piesa „' . $propunere->nume . '” pentru topul „Cea mai bună muzică veche”!');
                }
                break;
        }
    }

    public function mesaj()
    {
        return view('voteaza_si_propune.mesaj');
    }

    public function inregistrareTombolaPasul1(Request $request)
    {
        if (!$request->session()->exists('inregistrareTombolaLaTop')){
            return redirect('/voteaza-si-propune/adauga');
        }

        return view('voteaza_si_propune.inregistrareTombolaPasul1');
    }

    public function postInregistrareTombolaPasul1(Request $request)
    {
        if (!$request->session()->exists('inregistrareTombolaLaTop')){
            return redirect('/voteaza-si-propune/adauga');
        }

        $request->validate([
            'nume' => 'required|max:200',
            'telefon' => ['required', 'digits:10',
                // function ($attribute, $value, $fail) use ($request) {
                //     if (!empty($request->telefon)){
                //         $tombole = Tombola::whereDate('created_at', '>=', Carbon::today()->startOfWeek())
                //             ->where('top', session('inregistrareTombolaLaTop'))
                //             ->where(function ($query) use($request){
                //                 return $query
                //                     ->where('telefon', $request->telefon);
                //             })
                //             ->get();
                //         if ($tombole->count() > 0) {
                //             $fail('La acest top a fost facută deja o înregistrare, cu acest număr de telefon. Vă puteți înregistra din nou săptămâna viitoare. Puteți vota și să vă înregistrați și la celelalte topuri.');
                //         }
                //     }
                // },
            ],
            'email' => 'required|max:200|email:rfc,dns',
            'gdpr' => 'required'
        ]);

        switch(session('inregistrareTombolaLaTop')) {
            case "Românești de azi":
                $ultimulCod = Variabila::where('nume', 'ultimul_cod_tombola_romanesti_de_azi')->first();
                break;
            case 'Cea mai 9 muzică bună':
                $ultimulCod = Variabila::where('nume', 'ultimul_cod_tombola_cea_mai_9_muzica_buna')->first();
                break;
            case 'Cea mai bună muzică veche':
                $ultimulCod = Variabila::where('nume', 'ultimul_cod_tombola_cea_mai_buna_muzica_veche')->first();
                break;
        }
        $ultimulCod->valoare = substr($ultimulCod->valoare, 0, 3) . (intval(substr($ultimulCod->valoare, 3)) + 1);
        $ultimulCod->save();

        $tombola = new Tombola;
        $tombola->nume = $request->nume;
        $tombola->telefon = $request->telefon;
        $tombola->email = $request->email;
        $tombola->top = session('inregistrareTombolaLaTop');

        // $ultimulCod = Tombola::where('top', session('inregistrareTombolaLaTop'))->latest()->first()->cod ?? 'AAA130';
        // $tombola->cod = substr($ultimulCod, 0, 3) . (intval(substr($ultimulCod, 3)) + 1);
        $tombola->cod = $ultimulCod->valoare;

        $tombola->save();

        // Trimitere cod pe email
        Mail::to($tombola->email)->send(new \App\Mail\CodTombola($tombola));
        \App\Models\MesajTrimisEmail::create([
            'referinta' => 1,
            'referinta_id' => $tombola->id,
            'tip' => 1, // inscriere la tombola
            'email' => $tombola->email
        ]);

        $request->session()->put('tombola', $tombola);
        return redirect('/voteaza-si-propune/inregistrare-tombola-pasul-2');

    }

    public function inregistrareTombolaPasul2(Request $request)
    {
        if (!$tombola = $request->session()->get('tombola')) {
            return redirect('/voteaza-si-propune/adauga');
        }

        $request->session()->forget('inregistrareTombolaLaTop');

        return view('voteaza_si_propune.inregistrareTombolaPasul2', compact('tombola'));
    }
}
