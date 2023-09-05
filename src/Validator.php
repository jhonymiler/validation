<?php

namespace Jhony\Validation;

use Illuminate\Validation;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;

class Validator
{
    private $factory;
    private string $lang;

    public function __construct(string $lang = 'pt_BR')
    {
        $this->lang = $lang;
        $this->factory = new Validation\Factory(
            $this->loadTranslator()
        );
    }
    protected function loadTranslator()
    {
        $filesystem = new Filesystem();
        $loader = new Translation\FileLoader(
            $filesystem,
            dirname(dirname(__FILE__)) . '/lang'
        );
        $loader->addNamespace(
            'lang',
            dirname(dirname(__FILE__)) . '/lang'
        );
        $loader->load($this->lang, 'validation', 'lang');

        return new Translation\Translator($loader, $this->lang);
    }
    public function __call($method, $args)
    {
        return call_user_func_array(
            [$this->factory, $method],
            $args
        );
    }

    public function setLang(string $lang = 'en')
    {
        $this->lang = $lang;
    }
}
