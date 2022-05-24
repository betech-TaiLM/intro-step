<?php
namespace Bisync\IntroStep\Controllers\Api;

use App\Models\UserMaster;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Session;

class UserController extends Controller {
    public function store(Request $request) {
        if (Session::has('user')) {
            $user = UserMaster::find(Session::get('user')->user_master->id);
            $db   = [
                'tutorial_finished_flag' => $request->completed ? true : false,
            ];
            if ($user) {
                $user->update($db);
            }
        }
        return response()->json([], 204);
    }
}
