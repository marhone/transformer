<?php


namespace marhone\Transformer;


use Illuminate\Support\ServiceProvider;
use marhone\Transformer\Console\TransformerMakeCommand;

/**
 * Class TransformerServiceProvider
 * @package marhone\Transformer\Provider
 * @author marhone
 */
class TransformerServiceProvider extends ServiceProvider
{
    protected $commands = [
        TransformerMakeCommand::class
    ];

    public function boot()
    {
        $path = realpath(__DIR__ . '/../../config/config.php');

        $this->publishes([$path => config_path('transformer.php')], 'config');;
    }

    public function register()
    {
        $this->commands($this->commands);
    }
}