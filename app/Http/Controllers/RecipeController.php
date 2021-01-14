<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Recipe\CreateRecipeRequest;
use App\Http\Requests\Api\Recipe\UpdateRecipeRequest;
use App\Http\Resources\RecipeDetailedResource;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Recipes
 *
 * Class RecipeController
 * @package App\Http\Controllers
 */
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
        return response()->json(RecipeResource::collection($recipes));
    }

    /**
     * Display the specified resource.
     * @urlParam recipe integer required The ID of the recipe.
     *
     * @param Recipe $recipe
     * @return JsonResponse
     */
    public function show(Recipe $recipe)
    {
        return response()->json($recipe);
    }

    /**
     * Store a newly created resource in storage.
     * @authenticated
     *
     * @param CreateRecipeRequest $request
     * @return JsonResponse
     */
    public function store(CreateRecipeRequest $request)
    {
        return response()->json(Recipe::on()->create($request->validated()), 201);
    }

    /**
     * Update the specified resource in storage.
     * @authenticated
     * @urlParam recipe integer required The ID of the recipe.
     *
     * @param UpdateRecipeRequest $request
     * @param Recipe $recipe
     * @return JsonResponse
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        return response()->json(new RecipeDetailedResource($recipe));
    }

    /**
     * Remove the specified resource from storage.
     * @authenticated
     * @urlParam recipe integer required The ID of the recipe.
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
