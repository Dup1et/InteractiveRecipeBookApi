<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Recipe\CreateRecipeRequest;
use App\Http\Requests\Api\Recipe\UpdateRecipeRequest;
use App\Http\Resources\RecipeDetailed;
use App\Http\Resources\RecipeShort;
use App\Models\Recipe;
use Exception;
use Illuminate\Http\JsonResponse;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $recipes = Recipe::on()->with('language', 'user')->get();
        return response()->json(RecipeShort::collection($recipes));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRecipeRequest $request
     * @return JsonResponse
     */
    public function create(CreateRecipeRequest $request)
    {
        return response()->json(Recipe::on()->create($request->validated()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Recipe $recipe
     * @return JsonResponse
     */
    public function show(Recipe $recipe)
    {
        return response()->json($recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRecipeRequest $request
     * @param Recipe $recipe
     * @return JsonResponse
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        return response()->json(new RecipeDetailed($recipe));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Recipe $recipe
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Recipe $recipe)
    {
        return response()->json($recipe->delete(), 204);
    }
}
