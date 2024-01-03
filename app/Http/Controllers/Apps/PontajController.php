<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apps\Pontaj;
use App\Models\Apps\Actualizare;
use App\Models\Apps\Aplicatie;
use Carbon\Carbon;

class PontajController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('pontajReturnUrl');

        $searchAplicatie = $request->searchAplicatie;
        $searchActualizare = $request->searchActualizare;

        $query = Pontaj::with('actualizare.aplicatie')
            ->when($searchAplicatie, function ($query, $searchAplicatie) {
                $query->whereHas('actualizare', function ($query) use ($searchAplicatie) {
                    $query->whereHas('aplicatie', function ($query) use ($searchAplicatie) {
                        $query->where('nume', 'like', '%' . $searchAplicatie . '%');
                    });
                });
            })
            ->when($searchActualizare, function ($query, $searchActualizare) {
                $query->whereHas('actualizare', function ($query) use ($searchActualizare) {
                    $query->where('nume', 'like', '%' . $searchActualizare . '%');
                });
            })
            ->latest();

        $pontaje = $query->simplePaginate(50);

        return view('apps.pontaje.index', compact('pontaje', 'searchAplicatie', 'searchActualizare'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pontaj = new Pontaj;

        // Daca a fost adaugata o aplicatie din pontaj, se revine in formularul pontaj si campurile trebuie sa se recompleteze automat
        $pontaj->fill($request->session()->pull('pontajRequest', []));

        $aplicatii = Aplicatie::select('id', 'nume')->orderBy('nume')->get();
        $actualizari = Actualizare::select('id', 'nume')->orderBy('nume')->get();

        $request->session()->get('pontajReturnUrl') ?? $request->session()->put('pontajReturnUrl', url()->previous());

        return view('apps.pontaje.create', compact('pontaj', 'aplicatii', 'actualizari'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pontaj = Pontaj::create($this->validateRequest($request));

        return redirect($request->session()->get('pontajReturnUrl') ?? ('/app/pontaje'))->with('status', 'Pontajul pentru actualizarea „' . ($pontaj->actualizare->nume ?? '') . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pontaj  $pontaj
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Pontaj $pontaj)
    {
        $request->session()->get('pontajReturnUrl') ?? $request->session()->put('pontajReturnUrl', url()->previous());

        return view('apps.pontaje.show', compact('pontaj'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pontaj  $pontaj
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Pontaj $pontaj)
    {
        $request->session()->get('pontajReturnUrl') ?? $request->session()->put('pontajReturnUrl', url()->previous());

        $actualizari = Actualizare::select('id', 'nume')->get();

        return view('apps.pontaje.edit', compact('pontaj', 'actualizari'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pontaj  $pontaj
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pontaj $pontaj)
    {
        $pontaj->update($this->validateRequest($request));

        return redirect($request->session()->get('pontajReturnUrl') ?? ('/app/pontaje'))->with('status', 'Pontajul pentru actualizarea „' . ($pontaj->actualizare->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pontaj  $pontaj
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Pontaj $pontaj)
    {
        $pontaj->delete();

        return back()->with('status', 'Pontajul pentru actualizarea „' . ($pontaj->actualizare->nume ?? '') . '” a fost șters cu succes!');
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
                'data' => 'required|max:200',
                'timp' => 'nullable',
            ],
            [
                // 'tara_id.required' => 'Câmpul țara este obligatoriu'
            ]
        );
    }

    public function adaugaResursa(Request $request, $resursa = null)
    {
        $request->session()->put('pontajRequest', $request->all());

        switch($resursa){
            case 'aplicatie':
                $request->session()->put('aplicatieReturnUrl', url()->previous());
                return redirect('/apps/aplicatii/adauga');
                break;
            case 'actualizare':
                $request->session()->put('actualizareReturnUrl', url()->previous());
                return redirect('/apps/actualizari/adauga');
                break;
        }

    }
}
