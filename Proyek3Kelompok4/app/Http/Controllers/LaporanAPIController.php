<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class LaporanAPIController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response([
            'message' => 'Laporan API',
            'data' => $user
        ], 200);
    }
}
