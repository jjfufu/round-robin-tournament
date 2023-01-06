<?php

namespace RRTournament;

class OddCompetitorsNumberException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Competitors numbers must be even');
    }
}
