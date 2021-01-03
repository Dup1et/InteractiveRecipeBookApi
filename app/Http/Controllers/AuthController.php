<?php


namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Models\Language;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function loginWithGoogle()
    {
        return Socialite::driver('google')
            ->with([
                "access_type" => "offline",
                "prompt" => "consent select_account"
            ])
            ->stateless()
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::on()->where('google_id', $googleUser->id)->first();

            if ($user) {
                $user->avatar = $googleUser->avatar;
                $user->save();
            } else {
                $locale = isset($googleUser->user['locale']) ? $googleUser->user['locale'] : null;
                $user = User::on()->create([
                    'username' => $googleUser->nickname ?? $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'language_id' => $this->getLanguageIdForNewUser($locale),
                    'api_token' => $googleUser->token,
                    'avatar' => $googleUser->avatar
                ]);
            }

            /** @var User $user */
            $token = auth()->login($user);

            return $this->respondWithToken($token);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Get the language id based on locale tag
     *
     * @param string $locale
     * @return int
     */
    protected function getLanguageIdForNewUser($locale)
    {
        if (!$locale) {
            $locale = 'en';
        }
        try {
            return Language::on()
                ->where('tag', 'like', "%$locale%")
                ->first()
                ->id;
        } catch (ModelNotFoundException $exception) {
            return 2;
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource(auth()->user()),
        ]);
    }
}
