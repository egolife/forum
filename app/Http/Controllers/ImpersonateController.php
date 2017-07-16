<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonateController extends Controller
{
    /** @var ImpersonateManager */
    protected $manager;

    public function __construct()
    {
        $this->manager = app()->make(ImpersonateManager::class);
    }

    /**
     * Starts acting as provided user
     *
     * @param   User $user
     * @return  RedirectResponse
     */
    public function take(User $user)
    {
        $current_user = auth()->user() ?? new User();

        // Cannot impersonate yourself
        if ($user->id === $current_user->id) {
            abort(403, 'You cannot impersonate yourself');
        }

        // Cannot impersonate again if you're already impersonate a user
        if ($this->manager->isImpersonating()) {
            abort(403, 'You already impersonated someone, leave first!');
        }

        if (!$current_user->canImpersonate()) {
            abort(403, 'You don\'t have permission to impersonate users!');
        }

        if (!$user->canBeImpersonated()) {
            abort(403, 'Selected user can\'t be impersonated!!');

        }

        $this->manager->take($current_user, $user);

        return redirect()->route('home');
    }

    /*
     * @return RedirectResponse
     */
    public function leave()
    {
        if (!$this->manager->isImpersonating()) {
            abort(403, 'Currently you are not impersonating anyone');
        }

        $this->manager->leave();

        return redirect()->route('home');
    }
}
