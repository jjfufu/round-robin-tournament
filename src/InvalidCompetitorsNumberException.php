<?php

namespace RRTournament;

class InvalidCompetitorsNumberException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Competitors number must be greater than 2');
    }
}
