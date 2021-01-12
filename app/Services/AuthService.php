<?php


namespace App\Services;


use App\Models\Language;
use App\Models\User;
use App\Constants\Language as LanguageConstants;

class AuthService
{
    protected $tokenType = 'Bearer';

    /**
     * Find user by google id or create new user by google data
     *
     * @param $googleUser
     * @return User
     */
    public function findOrCreateUserWithGoogle($googleUser)
    {
        $user = User::on()->where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = User::on()->create([
                'username' => $googleUser->nickname ?? $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,
                'language_id' => $this->getLanguageIdForNewUser($googleUser->user['locale']),
                'google_id' => $googleUser->id,
            ]);
        }

        /** @var User $user */
        return $user;
    }

    /**
     * Log in user
     *
     * @param User $user
     * @return string
     */
    public function login(User $user)
    {
        return auth()->login($user);
    }

    /**
     * Refresh user access token
     *
     * @return string
     */
    public function refresh()
    {
        return auth()->refresh();
    }

    /**
     * Invalidate token
     */
    public function logout()
    {
        auth()->logout();
    }

    public function getTTL()
    {
        return auth()->factory()->getTTL() * 60;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * Get the language id based on locale tag
     *
     * @param string $locale
     * @return int
     */
    protected function getLanguageIdForNewUser($locale)
    {
        $languageId = Language::on()
            ->where('tag', 'like', "$locale")
            ->value('id');
        return $languageId ?? LanguageConstants::EN;
    }
}
