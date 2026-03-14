<?php

final class InvalidExternalTransactionId extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid external transaction ID');
    }
}