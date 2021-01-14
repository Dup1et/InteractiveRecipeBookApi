<?php


namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    protected $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

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
     * Obtain the user information from Google and log in user.
     *
     * @return JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = $this->authService->findOrCreateUserWithGoogle($googleUser);
            $token = $this->authService->login($user);

            return response()->json([
                'access_token' => $token,
                'token_type' => $this->authService->getTokenType(),
                'expires_in' => $this->authService->getTTL(),
                'user' => new UserResource(auth()->user()),
            ]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    /**
     * Refresh user access token.
     *
     * @return string
     */
    public function refresh()
    {
        $token = $this->authService->refresh();

        return response()->json([
            'access_token' => $token,
            'token_type' => $this->authService->getTokenType(),
            'expires_in' => $this->authService->getTTL(),
        ]);
    }

    /**
     * Log the user out.
     * @authenticated
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logout']);
    }
}
