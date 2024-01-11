<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Artist;
use App\Models\Imagine;

use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categorie = null)
    {
        $search_nume = \Request::get('search_nume');
        $artisti = Artist::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->simplePaginate(25);
        return view('artisti.index', compact('artisti', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('artisti.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();
        $artist = Artist::create($request->except(['imagine']));

        if($request->file()) {
            $nume = $request->file('imagine')->getClientOriginalName();
            $cale = '/uploads/imagini/artisti/' . $artist->id . '/';
            $request->file('imagine')->move(public_path() . $cale, $nume);

            $imagine = new Imagine;
            $imagine->referinta_id = $artist->id;
            $imagine->referinta_categorie = 'artisti';
            $imagine->imagine_nume = $nume;
            $imagine->imagine_cale = $cale;
            $imagine->save();
        }

        return redirect('/artisti')->with('status', 'Artistul „' . $artist->nume . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $piesa
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        return view('artisti.show', compact('artist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Piesa  $piesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist)
    {
        return view('artisti.edit', compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist)
    {
        // dd($artist, $request);
        $this->validateRequest();
        $artist->update($request->except(['imagine']));

        if($request->file()) {
            // stergerea imaginii vechi
            if ($artist->imagine){
                $cale_si_fisier = $artist->imagine->imagine_cale . $artist->imagine->imagine_nume;
                Storage::disk('public')->delete($cale_si_fisier);

                // dd($cale_si_fisier, Storage::disk('public'));

                //stergere director daca acesta este gol
                if (empty(Storage::disk('public')->allFiles($artist->imagine->imagine_cale))) {
                    Storage::disk('public')->deleteDirectory($artist->imagine->imagine_cale);
                }

                $artist->imagine->delete();
            }


            $nume = $request->file('imagine')->getClientOriginalName();
            $cale = '/uploads/imagini/artisti/' . $artist->id . '/';
            $request->file('imagine')->move(public_path() . '/' . $cale, $nume);

            $imagine = new Imagine;
            $imagine->referinta_id = $artist->id;
            $imagine->referinta_categorie = 'artisti';
            $imagine->imagine_nume = $nume;
            $imagine->imagine_cale = $cale;
            $imagine->save();
        }

        return redirect($artist->path())->with('status', 'Artistul „' . $artist->nume . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        $artist->delete();

        if ($artist->imagine){
            $cale_si_fisier = $artist->imagine->imagine_cale . $artist->imagine->imagine_nume;
            Storage::disk('public')->delete($cale_si_fisier);

            // dd($cale_si_fisier, Storage::disk('public'));

            //stergere director daca acesta este gol
            if (empty(Storage::disk('public')->allFiles($artist->imagine->imagine_cale))) {
                Storage::disk('public')->deleteDirectory($artist->imagine->imagine_cale);
            }

            $artist->imagine->delete();
        }

        return redirect('/artisti')->with('status', 'Artistul "' . $artist->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'nume' => 'required|max:250',
            'imagine' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'link' => 'nullable|max:250',
            'magazin_virtual' => 'nullable|max:250',
            'descriere' => 'nullable|max:2000',
        ]);
    }
}
