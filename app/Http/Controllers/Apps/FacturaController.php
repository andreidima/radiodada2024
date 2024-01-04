<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Apps\Aplicatie;
use App\Models\Apps\Actualizare;
use App\Models\Apps\Factura;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('facturaReturnUrl');

        // $searchNume = $request->searchNume;

        $facturi = Factura::
            // when($searchNume, function ($query, $searchNume) {
            //     return $query->where('numar', $searchNume);
            // })
            latest()
            ->simplePaginate(50);

        return view('apps.facturi.index', compact('facturi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('facturaReturnUrl') ?? $request->session()->put('facturaReturnUrl', url()->previous());

        $actualizari = Actualizare::select('id', 'aplicatie_id', 'nume')
            ->where('pret', '<>', NULL)
            ->where('factura_id', null)
            ->orderBy('nume')
            ->get();

        $aplicatii = Aplicatie::select('id', 'nume')->whereIn('id' , $actualizari->pluck('aplicatie_id'))->get();

        return view('apps.facturi.create', compact('aplicatii', 'actualizari'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->request);
        $this->validateRequest($request);
        $factura = Factura::make($this->validateRequest($request));
        $factura->seria = "APP";
        $factura->numar = (Factura::select('numar')->where('seria', "APP")->latest()->first()->numar ?? 0) + 1;
        $factura->save();

        return redirect($request->session()->get('facturaReturnUrl') ?? ('/app/facturi'))->with('status', 'Factura „' . $factura->numar . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Factura $factura)
    {
        $request->session()->get('facturaReturnUrl') ?? $request->session()->put('facturaReturnUrl', url()->previous());

        return view('apps.facturi.show', compact('factura'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Factura $factura)
    {
        $request->session()->get('facturaReturnUrl') ?? $request->session()->put('facturaReturnUrl', url()->previous());

        return view('apps.facturi.edit', compact('factura'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $factura)
    {
        $factura->update($this->validateRequest($request));

        return redirect($request->session()->get('facturaReturnUrl') ?? ('/apps/facturi'))->with('status', 'Factura „' . $factura->numar . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Factura $factura)
    {
        $factura->delete();

        return back()->with('status', 'Factura „' . $factura->numar . '” a fost ștearsă cu succes!');
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
                'actualizariAdaugateLaFactura' => 'required',
                // 'seria' => 'nullable|max:10',
                // 'numar' => 'nullable|max:200',
                // 'github_url' => 'nullable|max:200',
            ],
            [
                // 'tara_id.required' => 'Câmpul țara este obligatoriu'
            ]
        );
    }
}
