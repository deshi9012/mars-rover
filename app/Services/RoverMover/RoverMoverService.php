<?php

namespace App\Services\RoverMover;

use App\Interfaces\RoverMoverInterface;
use App\Models\Rover;
use App\Models\GridMap;
use Exception;

class RoverMoverService implements RoverMoverInterface
{
    private $rover;
    private $gridMap;
    public function __construct(Rover $rover, GridMap $gridMap)
    {
        $this->rover = $rover;
        $this->gridMap = $gridMap;
    }

    /**
     * @throws Exception
     */
    public function moveForward():void
    {
        if ($this->isRoverReachGridLimits()) {
            throw new Exception('You reached limits of the field !');
        }
        $roverDirection = $this->rover->getDirection();
        [$roverXCoordinates, $roverYCoordinates] = $this->rover->getCoordinates();

        switch ($roverDirection) {
            case "N":
                $this->rover->setYAxisCoordinate($roverYCoordinates++);
                break;
            case "E":
                $this->rover->setXAxisCoordinate($roverXCoordinates++);
                break;
            case "S":
                $this->rover->setYAxisCoordinate($roverYCoordinates--);
                break;

            case "W":
                $this->rover->setXAxisCoordinate($roverXCoordinates--);
                break;
            default:
                throw new Exception('Invalid direction');
        }
    }

    /**
     * @throws Exception
     */
    public function leftTurn():void
    {
        $roverDirection = $this->rover->getDirection();

        switch ($roverDirection) {
            case "N":
                $this->rover->setDirection("W");
                break;
            case "W":
                $this->rover->setDirection("S");
                break;
            case "S":
                $this->rover->setDirection("E");
                break;
            case "E":
                $this->rover->setDirection("N");
                break;
            default:
                throw new Exception('Invalid direction: ' . $roverDirection);
        }
    }
    public function rightTurn():void
    {
        $roverDirection = $this->rover->getDirection();
        switch ($roverDirection) {
            case "N":
                $this->rover->setDirection("E");
                break;
            case "E":
                $this->rover->setDirection("S");
                break;
            case "S":
                $this->rover->setDirection("W");
                break;
            case "W":
                $this->rover->setDirection("N");
                break;
            default:
                throw new Exception('Invalid direction:' . $roverDirection);
        }
    }

    public function spinRover(string $roverDirection):void
    {
        if ($roverDirection == "L") {
            $this->leftTurn() ;
        } else {
            $this->rightTurn();
        }
    }

    public function isRoverReachGridLimits():bool
    {
        [$roverXCoordinates, $roverYCoordinates] = $this->rover->getCoordinates();
        [$gridMapXAxesLength, $gridMapYAxesLength] = $this->gridMap->getCoordinates();

        $isRoverOutOfXAxes = $roverXCoordinates < 0 || $roverXCoordinates > $gridMapXAxesLength;
        $isRoverOutOfYAxes = $roverYCoordinates < 0 || $roverYCoordinates > $gridMapYAxesLength;

        return ($isRoverOutOfXAxes || $isRoverOutOfYAxes);
    }

    /**
     * @throws Exception
     */
    public function executeCommands(string $commands):void
    {
        $separatedCommands = str_split($commands);
        foreach ($separatedCommands as $command) {
            switch ($command) {
                case 'M':
                    $this->moveForward();
                    break;
                case 'L':
                case 'R':
                    $this->spinRover($command);
                    break;
                default:
                    throw new Exception('Invalid command: ' .  $command);
            }
        }
    }
    public function getFinalCoordinatesAndDirection(): string
    {
        [$roverXCoordinates, $roverYCoordinates] = $this->rover->getCoordinates();
        $roverDirection = $this->rover->getDirection();

        return $roverXCoordinates . 'x' . $roverYCoordinates . ' ' . $roverDirection;
    }
}
