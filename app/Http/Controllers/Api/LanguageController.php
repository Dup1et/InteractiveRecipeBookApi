<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Http\JsonResponse;

/**
 * @group Languages
 *
 * Class LanguageController
 * @package App\Http\Controllers
 */
class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $languagesList = Language::on()->get();
        return response()->json(LanguageResource::collection($languagesList));
    }

    /**
     * Display the specified resource.
     * @urlParam language integer required The ID of the language.
     *
     * @param  Language  $language
     * @return JsonResponse
     */
    public function show(Language $language)
    {
        return response()->json(new LanguageResource($language));
    }
}
