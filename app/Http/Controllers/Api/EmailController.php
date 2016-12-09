<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use Illuminate\Mail\Message;
use Mail;

class EmailController extends Controller
{
    public function email(EmailRequest $request)
    {
        extract($request->only(['name', 'message', 'email']), EXTR_SKIP);
        try {
            Mail::raw($message, function (Message $m) use ($name, $email) {
                $m->from($email, $name . ' ('.$email.')');
                $m->replyTo($email, $name);
                $m->to(env('EMAIL_CONTACT', 'contact@forum-am.fr'))->subject('Nouveau message depuis le site !');
            });
        } catch (\Exception $e) {
            return response()->json([
                'code'    => 500,
                'errors' => 'Une erreur s\'est produite, 
                    veuillez réessayer plus tard, ou en informer l\'adminsitrateur.',
                'exception' => $e->getMessage()
            ], 500);
        }


        return response()->json([
            'code'    => 200,
            'message' => 'Votre message a bien été envoyé, nous le traiterons dès que possible.',
        ], 200);
    }
}
