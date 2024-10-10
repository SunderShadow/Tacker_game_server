<?php

namespace Core\Message\Error;

readonly class UndefinedAction extends Error
{
    public function __construct()
    {
        parent::__construct(
            message: 'Undefined action'
        );
    }
}