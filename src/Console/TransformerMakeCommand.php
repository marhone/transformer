<?php


namespace marhone\Transformer\Console;


use Illuminate\Foundation\Console\ResourceMakeCommand;

class TransformerMakeCommand extends ResourceMakeCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:transformer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->collection()
            ? __DIR__.'/stubs/resource-collection.stub'
            : __DIR__.'/stubs/resource.stub';
    }
}