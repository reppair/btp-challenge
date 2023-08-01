<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class GetUsersController extends Controller
{
    public function __invoke(Request $request): UserCollection
    {
        // todo: replace with a repository or a dedicated action class? Whatever, KISS (for now).
        $users = User::query();

        if ($request->has('with') && $request->with == 'weather') {
            $users->with('weather');
        }

        return UserCollection::make($users->get());
    }
}
