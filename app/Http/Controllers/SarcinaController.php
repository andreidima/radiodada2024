<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sarcina;
use App\Models\Apps\Pontaj;
use App\Models\Apps\Actualizare;
use App\Models\Apps\Aplicatie;
use Carbon\Carbon;

class SarcinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('sarcinaReturnUrl');

        // $searchAplicatie = $request->searchAplicatie;

        // $query = Sarcina::with('actualizare.aplicatie')
        //     ->when($searchActualizareId, function ($query, $searchActualizareId) {
        //         $query->whereHas('actualizare', function ($query) use ($searchActualizareId) {
        //             $query->where('id', $searchActualizareId);
        //         });
        //     })
        //     ->when($searchData, function ($query, $searchData) {
        //         $query->whereDate('inceput', $searchData . '%');
        //     })
        //     ->latest();

        // $sarcini = $query->simplePaginate(50);

        return view('sarcini.index', compact());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sarcina = new Sarcina;

        $aplicatii = Aplicatie::select('id', 'nume')->orderBy('nume')->get();
        $actualizari = Actualizare::select('id', 'nume')->orderBy('nume')->get();

        $request->session()->get('sarcinaReturnUrl') ?? $request->session()->put('sarcinaReturnUrl', url()->previous());

        return view('sarcini.create', compact('pontaj', 'aplicatii', 'actualizari'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $sarcina = Sarcina::create($this->validateRequest($request));

        return redirect($request->session()->get('sarcinaReturnUrl') ?? ('/app/sarcini'))->with('status', 'Sarcina pentru actualizarea „' . ($sarcina->actualizare->nume ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sarcina  $sarcina
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sarcina $sarcina)
    {
        $request->session()->get('sarcinaReturnUrl') ?? $request->session()->put('sarcinaReturnUrl', url()->previous());

        return view('sarcini.show', compact('pontaj'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sarcina  $sarcina
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Sarcina $sarcina)
    {
        $aplicatii = Aplicatie::select('id', 'nume')->orderBy('nume')->get();
        $actualizari = Actualizare::select('id', 'nume')->orderBy('nume')->get();

        $request->session()->get('sarcinaReturnUrl') ?? $request->session()->put('sarcinaReturnUrl', url()->previous());

        return view('sarcini.edit', compact('pontaj', 'aplicatii', 'actualizari'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sarcina  $sarcina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sarcina $sarcina)
    {
        $sarcina->update($this->validateRequest($request));

        return redirect($request->session()->get('sarcinaReturnUrl') ?? ('/app/sarcini'))->with('status', 'Sarcina pentru actualizarea „' . ($sarcina->actualizare->nume ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sarcina  $sarcina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sarcina $sarcina)
    {
        $sarcina->delete();

        return back()->with('status', 'Sarcina pentru actualizarea „' . ($sarcina->actualizare->nume ?? '') . '” a fost ștearsă cu succes!');
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
                'actualizare_id' => 'required',
                'inceput' => 'required',
            ],
            [

            ]
        );
    }
}
