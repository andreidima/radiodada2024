<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Artist;
use App\Models\Imagine;
use App\Models\Propunere;

class SiteDadaMusicController extends Controller
{
    public function afisareArtisti(Artist $artist = null)
    {
        $artisti = Artist::select('id', 'nume')->orderBy('nume')->get();

        // Search this artist in the „propuneri” table, because if any mach is founded, it will be desplayed a link to them in the view
        if ($artist && $artist->nume){
            $propuneri = Propunere::select('id', 'nume')
                ->where('nume', 'like', $artist->nume . '%')
            ->get();
            // foreach ($propuneri as $propunere){
            //     if (str_contains($propunere->nume, $artist->nume)) {
            //         $existaPropuneriPentruAcestArtist = true;
            //         break;
            //     }
            // }
        }

        return view('site.dadaMusic.afisareArtisti', compact('artist', 'artisti', 'propuneri'));
    }
}
