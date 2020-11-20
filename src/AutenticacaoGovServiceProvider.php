<?php

namespace Noop\AutenticacaoGov;

use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\ServiceProvider;

class AutenticacaoGovServiceProvider extends SocialiteServiceProvider
{
    public function register()
    {
        $this->app->singleton('Laravel\Socialite\Contracts\Factory', function ($app) {
            return new AutenticacaoGovManager($app);
        });
    }

}