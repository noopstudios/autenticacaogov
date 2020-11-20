<?php
namespace Noop\AutenticacaoGov;

use Laravel\Socialite\SocialiteManager;

class AutenticacaoGovManager extends SocialiteManager
{
    protected function createAutenticacaoGovDriver()
    {
        $config = $this->app['config']['services.autenticacaogov'];
        return $this->buildProvider(
            'Noop\AutenticacaoGov\AutenticacaoGovProvider', $config
        );
    }


}
