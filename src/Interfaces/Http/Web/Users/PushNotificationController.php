<?php
namespace Interfaces\Http\Web\Users;

use Illuminate\Http\Request;
use Infra\Abstracts\Controller;

class PushNotificationController extends Controller
{
    public function updateToken(Request $request){
        $request->user()->update([
            'fcm_token' => $request->token
        ]);

        return response()->json([
            'success'=> true
        ]);
    }
}
