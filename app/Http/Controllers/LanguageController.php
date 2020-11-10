<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Response;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response(Language::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return response(Language::on()->findOrFail($id));
    }
}
