<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EmailRequest;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Mail\Message;
use Mail;

class EmailController extends Controller
{
    public function email(EmailRequest $request)
    {
        extract($request->only(['name', 'message', 'email']));
        Mail::raw($message, function (Message $m) use ($name, $email) {
            $m->from('contact@forum-am.fr', 'Site Forum AM');
            $m->replyTo($email, $name);
            $m->to(env('EMAIL_CONTACT', 'contact@forum-am.fr'))->subject('Nouveau message depuis le site !');
        });
    }
}
