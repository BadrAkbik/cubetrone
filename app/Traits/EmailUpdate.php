<?php

namespace App\Traits;

trait EmailUpdate
{
    public function emailVerificationReset($user) {

        if($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
        }
    }
}
