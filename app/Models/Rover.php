<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GridMap;
use Exception;

class Rover extends Model
{
    private $xAxisCoordinates;
    private $yAxisCoordinates;
    private $direction;

    public function getCoordinates (): array
    {
        return [$this->xAxisCoordinates,$this->yAxisCoordinates];
    }

    public function setXAxisCoordinate(int $newCoordinates):int
    {
        return $this->xAxisCoordinates = $newCoordinates;
    }

    public function setYAxisCoordinate(int $newCoordinates):int
    {
        return $this->yAxisCoordinates = $newCoordinates;
    }

    /**
     * @throws Exception
     */
    public function setCoordinates(string $roverCoordinatesData):array
    {
        $roverCoordinates = explode('x', $roverCoordinatesData);
        if (count($roverCoordinates) != 2) {
            throw new Exception('Invalid rover coordinates data!');
        }

        if (!is_numeric($roverCoordinates[0]) || !is_numeric($roverCoordinates[1])) {
            throw new Exception('Invalid rover coordinates data!');
        }

        return [$this->xAxisCoordinates,$this->yAxisCoordinates] = $roverCoordinates;
    }

    /**
     * @throws Exception
     */
    public function setDirection(string $direction) : void
    {
        if (!in_array($direction, ['N', 'E', 'S', 'W'])) {
            throw new Exception('Invalid rover direction: ' .  $direction);
        }
        $this->direction = $direction;
    }

    public function getDirection() : string
    {
        return $this->direction;
    }
}
