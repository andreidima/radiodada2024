<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apps\Actualizare;
use App\Models\Apps\Aplicatie;
use Carbon\Carbon;

class ActualizareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('actualizareReturnUrl');

        $searchNume = $request->searchNume;

        $query = Actualizare::
            when($searchNume, function ($query, $searchNume) {
                return $query->where('nume', $searchNume);
            })
            ->orderBy('id', 'desc');
            // ->latest();

        $actualizari = $query->simplePaginate(50);

        return view('apps.actualizari.index', compact('actualizari', 'searchNume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('actualizareReturnUrl') ?? $request->session()->put('actualizareReturnUrl', url()->previous());

        $aplicatii = Aplicatie::select('id', 'nume')->get();

        return view('apps.actualizari.create', compact('aplicatii'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actualizare = Actualizare::create($this->validateRequest($request));

        return redirect($request->session()->get('actualizareReturnUrl') ?? ('/apps/actualizari'))->with('status', 'Actualizarea „' . $actualizare->nume . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actualizare  $actualizare
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Actualizare $actualizare)
    {
        $request->session()->get('actualizareReturnUrl') ?? $request->session()->put('actualizareReturnUrl', url()->previous());

        return view('apps.actualizari.show', compact('actualizare'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actualizare  $actualizare
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Actualizare $actualizare)
    {
        $request->session()->get('actualizareReturnUrl') ?? $request->session()->put('actualizareReturnUrl', url()->previous());

        $aplicatii = Aplicatie::select('id', 'nume')->get();

        return view('apps.actualizari.edit', compact('actualizare', 'aplicatii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actualizare  $actualizare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actualizare $actualizare)
    {
        $actualizare->update($this->validateRequest($request));

        return redirect($request->session()->get('actualizareReturnUrl') ?? ('/apps/actualizari'))->with('status', 'Actualizarea „' . $actualizare->nume . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actualizare  $actualizare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Actualizare $actualizare)
    {
        $actualizare->delete();

        return back()->with('status', 'Actualizarea „' . $actualizare->nume . '” a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        // Se adauga userul doar la adaugare, iar la modificare nu se schimba
        // if ($request->isMethod('post')) {
        //     $request->request->add(['user_id' => $request->user()->id]);
        // }

        // if ($request->isMethod('post')) {
        //     $request->request->add(['cheie_unica' => uniqid()]);
        // }

        return $request->validate(
            [
                'aplicatie_id' => 'required',
                'nume' => 'required|max:200',
                'pret' => 'nullable',
                'trimis_catre_facturare' => 'nullable',
                'confirmare_facturare' => 'nullable',
                'descriere' => 'nullable|max:2000',
                'observatii_pentru_client' => 'nullable|max:2000',
                'observatii_personale' => 'nullable|max:2000',
            ],
            [
                // 'tara_id.required' => 'Câmpul țara este obligatoriu'
            ]
        );
    }
}
