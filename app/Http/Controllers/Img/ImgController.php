<?php

namespace App\Http\Controllers\Img;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImgController extends Controller
{
    public function index()
    {
        return view('img');
    }
}
