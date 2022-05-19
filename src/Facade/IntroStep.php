<?php
namespace Bisync\IntroStep\Facade;

use Illuminate\Support\Facades\Facade;
use Modules\Admin\Models\IntroStepStepList;
use Modules\Admin\Models\UserMaster;
use Session;

class IntroStep extends Facade {
    protected static function getFacadeAccessor() {
        return 'introStep';
    }

    public static function viewWithIntro($view, $data = [], $mergeData = []) {
        $with = [];

        $step = IntroStepStepList::view($view);

        if ($step) {
            $with = [
                'is_active'    => filled($step),
                'is_auth'      => Session::has('user'),
                'is_auth_only' => $step->auth_only,
                'step'         => $step,
                'route'        => route('admin.store-intro-step'),
            ];

            if (Session::has('user')) {
                $user = UserMaster::getUserByMemberId(Session::get('user')['id']);
                $with = array_merge(['user' => $user], $with);
            }
        }

        return view($view, $data, $mergeData)->with(['intro_step' => $with]);
    }

    public static function getBladeScript($withScript = true) {
        $passed = '<?php
            if(isset($intro_step)) { ';
        $passed .= "echo '<script>window.IntroStep = '.json_encode(\$intro_step).';</script>';";
        if ($withScript) {
            $passed .= "echo '<link rel=stylesheet href=\'" . asset('vendor/bisync/intro-step/introjs.min.css') . "\' />';";
            $passed .= "echo '<script src=\'" . asset('vendor/bisync/intro-step/intro.min.js') . "\'></script>'; ";
            $passed .= "echo '<script src=\'" . asset('vendor/bisync/intro-step/intro-step.js') . "\'></script>';";
        }
        $passed .= '}?>';

        return $passed;
    }
}
