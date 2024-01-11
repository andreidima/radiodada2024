<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Propunere;

class PropunereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categorie = null)
    {
        $propuneri = Propunere::
            latest()
            ->simplePaginate(25);
        return view('propuneri.index', compact('propuneri'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Propunere  $propunere
     * @return \Illuminate\Http\Response
     */
    public function destroy(Propunere $propunere)
    {
        $propunere->delete();

        return redirect('/propuneri')->with('status', 'Propunerea "' . $propunere->nume . '" a fost ștearsă cu succes!');
    }
}
