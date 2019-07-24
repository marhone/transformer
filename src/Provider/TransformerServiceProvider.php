<?php


namespace marhone\Transformer\Provider;


use Illuminate\Support\ServiceProvider;

/**
 * Class TransformerServiceProvider
 * @package marhone\Transformer\Provider
 * @author marhone
 */
class TransformerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('transformer.php')], 'config');;
    }

    public function register()
    {
    }
}