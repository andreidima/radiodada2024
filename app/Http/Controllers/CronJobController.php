<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use App\Models\Tombola;

class CronJobController extends Controller
{
    public function extragereCastigatorTombola($key = null){
        if (is_null($keyDB = DB::table('variabile')->where('nume', 'cron_job_key')->get()->first()->valoare ?? null) || is_null($key) || ($keyDB !== $key)) {
            echo 'Cheia pentru Cron Joburi este incorectă!';
            return ;
        }

        // Sterge castigatorii pentru a putea extrage din nou
        // $tombole = Tombola::
        //     whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::today()->subDays(1)->endofDay()])
        //     ->update(['castigator' => null]);

        // Se fac 3 extrageri, pentru fiecare top in parte
        Tombola::inRandomOrder()
            ->whereNull('castigator')
            ->whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::today()->subDays(1)->endofDay()])
            ->where('top', 'Cea mai 9 muzică bună')
            ->limit(1)
            ->update(['castigator' => 1]);
        Tombola::inRandomOrder()
            ->whereNull('castigator')
            ->whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::today()->subDays(1)->endofDay()])
            ->where('top', 'Românești de azi')
            ->limit(1)
            ->update(['castigator' => 1]);
        Tombola::inRandomOrder()
            ->whereNull('castigator')
            ->whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::today()->subDays(1)->endofDay()])
            ->where('top', 'Cea mai bună muzică veche')
            ->limit(1)
            ->update(['castigator' => 1]);

        // Participantii care raman, sunt trecuti ca necastigatori
        Tombola::
            whereNull('castigator')
            ->whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::today()->subDays(1)->endofDay()])
            ->update(['castigator' => 0]);
    }
}