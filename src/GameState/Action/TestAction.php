<?php

namespace Core\GameState\Action;

class TestAction extends Action
{
    public function __invoke(): void
    {
        var_dump($this->data);
        echo "Test success", PHP_EOL;
    }
}