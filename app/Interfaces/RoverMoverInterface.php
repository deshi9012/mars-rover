<?php
namespace App\Interfaces;

interface RoverMoverInterface
{
    public function moveForward():void;
    public function leftTurn():void;
    public function rightTurn():void;
    public function spinRover(string $roverDirection):void;
    public function isRoverReachGridLimits():bool;
    public function executeCommands(string $commands):void;
}
