<?php

namespace App\Interfaces;

interface LandingMissionInterface
{
    public function moveForward(): void;

    public function rotateLeft(): void;

    public function rotateRight(): void;

    public function rotateRover(string $roverDirection): void;

    public function isRoverReachGridLimits(): bool;

    public function executeCommands(string $commands): void;
}
