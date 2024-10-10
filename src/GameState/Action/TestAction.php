<?php

namespace Core\GameState\Action;

use Respect\Validation\Mixins\ChainedValidator;
use Respect\Validation\Validator;
use Respect\Validation\Validator as v;

class TestAction extends Action
{
    protected function validator(): Validator|ChainedValidator
    {
        return v::create()
            ->key('test_key', v::stringVal())
            ->key('other_key', v::numericVal());
    }

    public function __invoke(): void
    {
        var_dump($this->data);
        echo "Test success", PHP_EOL;
    }
}