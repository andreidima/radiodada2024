<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Tombola;

class TombolaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchNume = $request->searchNume;
        $searchTelefon = $request->searchTelefon;
        $searchTop = $request->searchTop;
        $searchCastigator = $request->searchCastigator;
        $searchInterval = $request->searchInterval;

        $tombole = Tombola::
            when($searchNume, function ($query, $searchNume) {
                return $query->where('nume', 'like', '%' . $searchNume . '%');
            })
            ->when($searchTelefon, function ($query, $searchTelefon) {
                return $query->where('telefon', 'like', '%' . $searchTelefon . '%');
            })
            ->when($searchTop, function ($query, $searchTop) {
                return $query->where('top', 'like', '%' . $searchTop . '%');
            })
            ->when($searchCastigator, function ($query, $searchCastigator) {
                return $query->where('castigator', $searchCastigator);
            })
            ->when(($searchCastigator == "0"), function ($query) {
                return $query->where('castigator', 0);
            })
            ->when($searchInterval, function ($query, $searchInterval) {
                $inceput = Carbon::parse(strtok($searchInterval, ','));
                $sfarsit = Carbon::parse(strtok( '' ))->endOfDay();
                return $query->whereBetween('created_at', [$inceput, $sfarsit]);
            })
            ->where('id', '>', 16) // Cele de inceput cu Andrei Dima
            ->latest()
            ->simplePaginate(25);

        return view('tombole.index', compact('tombole', 'searchNume', 'searchTelefon', 'searchTop', 'searchCastigator', 'searchInterval'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tombola  $tombola
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tombola $tombola)
    {
        $tombola->delete();

        return redirect('/tombole')->with('status', 'Participantul "' . $tombola->nume . '" a fost șters cu succes!');
    }
}
