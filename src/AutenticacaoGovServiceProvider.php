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
        // parent::boot();
        $this->app->singleton('Laravel\Socialite\Contracts\Factory', function ($app) {
            return new AutenticacaoGovManager($app);
        });/*
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'autenticacaogov',
            function ($app) use ($socialite) {
                $config = $app['config']['services.autenticacaogov'];
                return $socialite->buildProvider(AutenticacaoGov::class, $config);
            }
        );*/
    }

}