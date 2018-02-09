<?php

namespace qfproject\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
    public function mostrar(){
     return view('ayuda.manual');
    }

    

}