<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GridMap;
use Exception;

class Rover extends Model
{
    private $gridMap;
    private $xAxisCoordinates;
    private $yAxisCoordinates;
    private $roverDirection;

    public function __construct(GridMap $gridMap)
    {
        $this->gridMap = $gridMap;
    }

    public function getXAxisCoordinates()
    {
        return $this->xAxisCoordinates;
    }

    public function getYAxisCoordinates()
    {
        return $this->yAxisCoordinates;
    }

    public function getCoordinatesAndHeadingDirection()
    {
        return $this->xAxisCoordinates . 'x' . $this->yAxisCoordinates . ' ' . $this->roverDirection;
    }

    public function setCoordinates(string $roverCoordinatesData)
    {
        $roverCoordinates = explode('x', $roverCoordinatesData);
        if (count($roverCoordinates) != 2) {
            throw new Exception('Invalid rover coordinates data!');
        }

        if (!is_numeric($roverCoordinates[0]) || !is_numeric($roverCoordinates[1])) {
            throw new Exception('Invalid rover coordinates data!');
        }


        $this->xAxisCoordinates = $roverCoordinates[0];
        $this->yAxisCoordinates = $roverCoordinates[1];
    }

    public function setRoverDirection(string $roverDirection) : void
    {
        if (!in_array($roverDirection, ['N', 'E', 'S', 'W'])) {
            throw new Exception('Invalid rover direction: ' .  $roverDirection);
        }
        $this->roverDirection = $roverDirection;
    }

    public function executeCommands($commands)
    {
        $separatedCommands = str_split($commands);
        foreach ($separatedCommands as $command) {
            switch ($command) {
                case 'M':
                    $this->moveForward();
                    break;
                case 'L':
                case 'R':
                    $this->spinRoadster($command);
                    break;
                default:
                    throw new Exception('Invalid command: ' .  $command);
                }
        }
    }

    private function moveForward()
    {
        if ($this->isRoverReachGridLimits()) {
            throw new Exception('You reached limits of the field !');
        }

        switch ($this->roverDirection) {
            case "N":
                $this->yAxisCoordinates++;
                break;
            case "E":
                $this->xAxisCoordinates++;
                break;
            case "S":
                $this->yAxisCoordinates--;
                break;

            case "W":
                $this->xAxisCoordinates--;
                break;
            default:
                throw new Exception('Invalid direction');
        }
    }

    private function leftTurn()
    {
        switch ($this->roverDirection) {
            case "N":
                $this->roverDirection = "W";
                break;
            case "W":
                $this->roverDirection = "S";
                break;
            case "S":
                $this->roverDirection = "E";
                break;
            case "E":
                $this->roverDirection = "N";
                break;
            default:
                throw new Exception('Invalid direction: ' . $this->roverDirection);
        }
    }

    private function rightTurn()
    {
        switch ($this->roverDirection) {
            case "N":
                $this->roverDirection = "E";
                break;
            case "E":
                $this->roverDirection = "S";
                break;
            case "S":
                $this->roverDirection = "W";
                break;
            case "W":
                $this->roverDirection = "N";
                break;
            default:
                throw new Exception('Invalid direction:' . $this->roverDirection);
        }
    }

    private function spinRoadster($roverDirection)
    {
        if ($roverDirection == "L") {
            $this->leftTurn() ;
        } else {
            $this->rightTurn();
        }
    }

    private function isRoverReachGridLimits() : bool
    {
        return ($this->xAxisCoordinates < 0 || $this->xAxisCoordinates > $this->gridMap->getXAxis() || $this->yAxisCoordinates < 0 || $this->yAxisCoordinates > $this->gridMap->getYAxis());
    }
}
