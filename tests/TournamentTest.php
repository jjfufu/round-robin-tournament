<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RRTournament\InvalidCompetitorsNumberException;
use RRTournament\OddCompetitorsNumberException;
use RRTournament\Tournament;

class TournamentTest extends TestCase
{
    public function testThrowErrorOnNegativeCompetitors(): void
    {
        $this->expectException(InvalidCompetitorsNumberException::class);
        new Tournament(-1);
    }

    public function testThrowErrorOnOddCompetitors(): void
    {
        $this->expectException(OddCompetitorsNumberException::class);
        new Tournament(13);
    }

    public function testTournamentReturnInteger(): void
    {
        $tournament = new Tournament(6);

        $this->assertIsInt($tournament->getCompetitorsNumber());
    }

    public function testTournamentReturnCorrectNumberOfCompetitors(): void
    {
        $tournament = new Tournament(6);

        $this->assertEquals(6, $tournament->getCompetitorsNumber());
    }

    public function testThrowErrorOnInvalidCompetitorsNumber(): void
    {
        $this->expectException(InvalidCompetitorsNumberException::class);
        new Tournament(2);
    }

    public function testGetTotalRoundsReturnInteger(): void
    {
        $tournament = new Tournament(4);

        $this->assertIsInt($tournament->getTotalRounds());
    }

    public function testGetCurrentRoundReturnInteger(): void
    {
        $tournament = new Tournament(4);

        $this->assertIsInt($tournament->getCurrentRound());
    }

    public function testIncrementRound(): void
    {
        $tournament = new Tournament(4);
        $tournament->incrementRound();
        $this->assertEquals(2, $tournament->getCurrentRound());
    }

    public function testGetTotalRoundsReturnValidNumber(): void
    {
        $tournament = new Tournament(4);

        $this->assertEquals(3, $tournament->getTotalRounds());
    }

    public function testArrayElementsAreCorrectlyMoved(): void
    {
        $row = [1, 2, 3, 4, 5];
        $excepted = [3, 4, 5, 1, 2];

        $tournament = new Tournament(6);
        $tournament->move($row, 2, 0);
        $this->assertEquals($excepted, $row);
    }

    public function testGetTableReturnCorrectSchedule(): void
    {
        $expected = [
            [1, 2, 3, 4, 5],
            [4, 5, 1, 2, 3],
            [2, 3, 4, 5, 1],
            [5, 1, 2, 3, 4],
            [3, 4, 5, 1, 2]
        ];
        $tournament = new Tournament(6);

        $this->assertEquals($expected, $tournament->getTable());
    }

    public function testGetRoundReturnArray(): void
    {
        $tournament = new Tournament(12);
        $this->assertIsArray($tournament->getRound());
    }

    public function testGetRoundHasValidCompetitors(): void
    {
        $tournament = new Tournament(6);
        $this->assertEquals([[1, 6], [2, 5], [3, 4]], $tournament->getRound());
    }

    public function testGetRoundsReturnArray(): void
    {
        $tournament = new Tournament(12);
        $this->assertIsArray($tournament->getRounds());
    }

    public function testGetRoundsReturnValidRounds(): void
    {
        $expected = [
            [[1, 6], [2, 5], [3, 4]],
            [[4, 6], [5, 3], [1, 2]],
            [[2, 6], [3, 1], [4, 5]],
            [[5, 6], [1, 4], [2, 3]],
            [[3, 6], [4, 2], [5, 1]]
        ];

        $tournament = new Tournament(6);
        $this->assertEquals($expected, $tournament->getRounds());
    }
}
