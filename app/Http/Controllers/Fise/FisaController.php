<?php

namespace App\Http\Controllers\Fise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Fise\Fisa;
use Carbon\Carbon;

class FisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('fisaReturnUrl');

        $searchNume = $request->searchNume;

        $query = Fisa::
            when($searchNume, function ($query, $searchNume) {
                return $query->where('nume', $searchNume);
            })
            ->latest();

        $fise = $query->simplePaginate(50);

        return view('fise.fise.index', compact('fise', 'searchNume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('fisaReturnUrl') ?? $request->session()->put('fisaReturnUrl', url()->previous());

        return view('fise.fise.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fisa = Fisa::create($this->validateRequest($request));

        return redirect($request->session()->get('fisaReturnUrl') ?? ('/fise/fise'))->with('status', 'Fișa „' . $fisa->nume . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fisa  $fisa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Fisa $fisa)
    {
        $request->session()->get('fisaReturnUrl') ?? $request->session()->put('fisaReturnUrl', url()->previous());

        return view('fise.fise.show', compact('fisa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fisa  $fisa
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Fisa $fisa)
    {
        $request->session()->get('fisaReturnUrl') ?? $request->session()->put('fisaReturnUrl', url()->previous());

        return view('fise.fise.edit', compact('fisa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fisa  $fisa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fisa $fisa)
    {
        $fisa->update($this->validateRequest($request));

        return redirect($request->session()->get('fisaReturnUrl') ?? ('/fise/fise'))->with('status', 'Fișa „' . $fisa->nume . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fisa  $fisa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Fisa $fisa)
    {
        $fisa->delete();

        return back()->with('status', 'Fișa „' . $fisa->nume . '” a fost ștearsă cu succes!');
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
                'data' => 'required',
                'nume' => 'required|max:500',
                'cnp' => 'required|max:500',
                'varsta' => 'integer|between:1,100',
                'locatie' => 'nullable|max:500',
                'ahc' => 'nullable|max:500',
                'nr_nasteri' => 'integer|between:1,10',
                'perioada_alaptare' => 'nullable|max:500',
            ],
            [
                // 'tara_id.required' => 'Câmpul țara este obligatoriu'
            ]
        );
    }
}
