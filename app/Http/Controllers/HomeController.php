<?php

namespace App\Http\Controllers;
use App\Models\Documents;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $count = Documents::where('user_id', Auth::user()->id)->count();
        $documentData = Documents::where('user_id', Auth::user()->id)->get();
        return view('user.documents.index', [
            'documentCount' => $count,
            'documentData' => $documentData
        ]);
    }

}
