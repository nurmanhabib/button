<?php namespace Nurmanhabib\Button;

use Illuminate\Support\ServiceProvider;

class ButtonServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('button', function()
        {
            return new Button;
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Button', 'Nurmanhabib\Button\Facades\Button');
        });
    }

}