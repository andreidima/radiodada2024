<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Artist;
use App\Models\Imagine;
use App\Models\Piesa;

class SiteDadaMusicController extends Controller
{
    public function afisareArtisti(Artist $artist = null)
    {
        $artistiDeAfisatInGalerie = Artist::with('imagine')->has('imagine')->select('id', 'nume')->orderBy('nume')->simplePaginate(18);

        $artisti = Artist::select('id', 'nume')->orderBy('nume')->get();

        // Search this artist in the „propuneri” table, because if any mach is founded, it will be desplayed a link to them in the view
        $propuneri = [];
        if ($artist && $artist->nume){
            $propuneri = Piesa::with('artist')->select('id', 'nume', 'link_youtube')
                ->whereHas('artist', function (Builder $query) use ($artist) {
                    $query->where('nume', 'like', $artist->nume);
                })
                ->where('categorie', 'like', 'Propunere' . '%')
            ->get();
            // foreach ($propuneri as $propunere){
            //     if (str_contains($propunere->nume, $artist->nume)) {
            //         $existaPropuneriPentruAcestArtist = true;
            //         break;
            //     }
            // }
        }

        return view('site.dadaMusic.afisareArtisti', compact('artistiDeAfisatInGalerie', 'artist', 'artisti', 'propuneri'));
    }
}
