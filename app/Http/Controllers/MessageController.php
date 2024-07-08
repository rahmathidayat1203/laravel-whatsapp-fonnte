<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    public function send()
    {

        $users = User::all();

        foreach ($users as $key => $user) {
            $to = $user->no_hp;
            $message = 'halo selamat datand, ini hanya pesan testing';
            $response = $this->fonnte->sendMessage($to, $message);
            return response()->json($response);
        }
    }
}
