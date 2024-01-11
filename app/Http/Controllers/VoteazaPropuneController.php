<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Piesa;
use App\Models\Propunere;

use Illuminate\Support\Facades\Validator;

class VoteazaPropuneController extends Controller
{
    /**
     * Formular de votare piesa sau propunere piesa
     */
    public function create()
    {
        // config(['session.same_site' => 'none']);
        // dd(config('session.same_site'));
        $piese = Piesa::with('artist')->orderByDesc('voturi')->get();

        return view('voteaza_si_propune.create', compact('piese'));
    }


    /**
     * Salvează votarea piesei sau piesa propusa
     */
    public function store(Request $request)
    {
        // dd(config('session.same_site'));
        switch ($request->input('action')) {
            case 'top_international_voteaza':
                if ($request->session()->has('top_international_votat_deja_variabila_sesiune')) {
                    return back()->with('top_international_votat_deja', 'Ai votat deja pentru o piesă din acest top. Poți vota o singură dată.');
                } else {
                    request()->validate(
                        ['top_international_piesa' => 'required|integer'],
                        ['top_international_piesa.required' => 'Selectează piesa pe care dorești să o votezi.']
                    );

                    $piesa = Piesa::find($request->top_international_piesa);
                    $piesa->voturi ++ ;
                    $piesa->save();

                    $request->session()->put('top_international_votat_deja_variabila_sesiune', 'da');

                    // $request->session()->flash('Voteaza', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');

                    return back()->with('top_international_votat', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');
                    // return back();
                }
                break;

            case 'top_international_propunere':
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

                    return back()->with('top_international_propus', 'Ai propus piesa „' . $propunere->nume . '”!');
                }
                break;
            case 'top_romanesc_voteaza':
                if ($request->session()->has('top_romanesc_votat_deja_variabila_sesiune')) {
                    return back()->with('top_romanesc_votat_deja', 'Ai votat deja pentru o piesă din acest top. Poți vota o singură dată.');
                } else {
                    request()->validate(
                        ['top_romanesc_piesa' => 'required|integer'],
                        ['top_romanesc_piesa.required' => 'Selectează piesa pe care dorești să o votezi.']
                    );

                    $piesa = Piesa::find($request->top_romanesc_piesa);
                    $piesa->voturi ++ ;
                    $piesa->save();

                    $request->session()->put('top_romanesc_votat_deja_variabila_sesiune', 'da');

                    // $request->session()->flash('Voteaza', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');

                    return back()->with('top_romanesc_votat', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');
                    // return back();
                }
                break;

            case 'top_romanesc_propunere':
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

                    return back()->with('top_romanesc_propus', 'Ai propus piesa „' . $propunere->nume . '”!');
                }
                break;

            case 'top_veche_voteaza':
                if ($request->session()->has('top_veche_votat_deja_variabila_sesiune')) {
                    return back()->with('top_veche_votat_deja', 'Ai votat deja pentru o piesă din acest top. Poți vota o singură dată.');
                } else {
                    request()->validate(
                        ['top_veche_piesa' => 'required|integer'],
                        ['top_veche_piesa.required' => 'Selectează piesa pe care dorești să o votezi.']
                    );

                    $piesa = Piesa::find($request->top_veche_piesa);
                    $piesa->voturi ++ ;
                    $piesa->save();

                    $request->session()->put('top_veche_votat_deja_variabila_sesiune', 'da');

                    // $request->session()->flash('Voteaza', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');

                    return back()->with('top_veche_votat', 'Votul dumneavoastră pentru „' . ($piesa->artist->nume ?? '') . ' - ' . $piesa->nume . '” a fost inregistrat!');
                    // return back();
                }
                break;

            case 'top_veche_propunere':
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
                    $propunere->top = 'Top Cea mai bună muzică veche';
                    $propunere->save();

                    $request->session()->put('top_veche_propus_deja_variabila_sesiune', 'da');

                    return back()->with('top_veche_propus', 'Ai propus piesa „' . $propunere->nume . '”!');
                }
                break;
        }
    }

    public function mesaj()
    {
        return view('voteaza_si_propune.mesaj');
    }

    // De sters 01.03.2024
    // public function voteazaPropune(Request $request)
    // {
    //     switch ($request->input('action')) {
    //         case 'Voteaza':
    //             if ($request->session()->has('votat_deja')) {
    //                 return back()->with('error', 'Ai votat deja pentru o piesă din acest top. Poți vota o singură dată.');
    //             } else {
    //                 $piesa = Piesa::find($request->voteazaPiesa);
    //                 $piesa->voturi ++ ;
    //                 $piesa->save();

    //                 $request->session()->put('votat_deja', 'da');

    //                 return back()->with('status', 'Votul dumneavoastră pentru „' . $piesa->autor->nume . ' - ' . $piesa->nume . '” a fost inregistrat!');
    //             }
    //             break;

    //         case 'Propunere':
    //             if ($request->session()->has('propus_deja')) {
    //                 return back()->with('error', 'Ai propus deja o piesă pentru acest top. Poți propune o singură dată.');
    //             } else {
    //                 $propunere = new Propunere;
    //                 $propunere->nume = $request->propunere;
    //                 $propunere->save();

    //                 $request->session()->put('propus_deja', 'da');

    //                 return back()->with('status', 'Ai propus piesa „' . $propunere->nume . '”!');
    //             }
    //             break;
    //     }

    //     $piese = Piesa::with('artist')->orderByDesc('voturi')->get();

    //     return view('voteaza_si_propune.create', compact('piese'));
    // }
}
