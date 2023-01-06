<?php

namespace RRTournament;

class Tournament
{
    private array $table;
    private int $currentRound = 1;

    public function __construct(
        private readonly int $competitors
    )
    {
        if($this->competitors <= 2) {
            throw new InvalidCompetitorsNumberException();
        }

        if($this->competitors % 2 !== 0) {
            throw new OddCompetitorsNumberException();
        }

        $this->initTable();
    }

    public function getCompetitorsNumber(): int
    {
        return $this->competitors;
    }

    public function getTotalRounds(): int
    {
        return $this->getCompetitorsNumber() - 1;
    }

    public function getCurrentRound(): int
    {
        return $this->currentRound;
    }

    public function incrementRound(): void
    {
        $this->currentRound++;
    }

    public function getTable(): array
    {
        return $this->table;
    }

    private function initTable(): void
    {
        // directly add the first row in table
        $table = [range(1, $this->getTotalRounds())];

        // create all other rows.
        // move all competitors between index X and Y to the top of the array
        // X = (competitors number / 2)
        // Y = array length - 1
        for($i = 1; $i < $this->getTotalRounds(); $i++) {
            $row = $table[$i - 1];

            $from = $this->getCompetitorsNumber() / 2;
            if($from > $this->getTotalRounds()) {
                $from -= $this->getTotalRounds();
            }

            $this->move($row, $from, 0);

            $table[] = $row;
        }

        $this->table = $table;
    }

    public function move(array &$row, int $from, int $to): void
    {
        $out = array_splice($row, $from);
        array_splice($row, $to, 0, $out);
    }

    public function getRound(): array
    {
        $prevRow = $this->getTable()[$this->getCurrentRound() - 1];

        // first match is between first row element and fixed competitor (last competitor)
        $round[] = [array_shift($prevRow), $this->getCompetitorsNumber()];
        while(count($prevRow)) {
            $round[] = [array_shift($prevRow), array_pop($prevRow)];
        }

        $this->incrementRound();

        return $round;
    }

    public function getRounds(): array
    {
        $rounds = [];

        for($round = 0; $round < $this->getTotalRounds(); $round++) {
            $rounds[] = $this->getRound();
        }

        return $rounds;
    }
}
