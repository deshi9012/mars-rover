<?php

namespace App\Models;

use App\Constants\Common\CardinalDirections;
use App\Constants\Rover\RoverCommonConstants;
use App\Exceptions\RoverException;
use Illuminate\Database\Eloquent\Model;

class Rover extends Model
{

    /**
     * @var
     */
    private $xAxisCoordinates;

    /**
     * @var
     */
    private $yAxisCoordinates;

    /**
     * @var
     */
    private $direction;


    /**
     * @return array
     */
    public function getCoordinates(): array
    {
        return [$this->xAxisCoordinates, $this->yAxisCoordinates];
    }

    /**
     * @param int $newXCoordinates
     * @return int
     */
    public function setXAxisCoordinate(int $newXCoordinates): int
    {
        return $this->xAxisCoordinates = $newXCoordinates;
    }

    /**
     * @param int $newYCoordinates
     * @return int
     */
    public function setYAxisCoordinate(int $newYCoordinates): int
    {
        return $this->yAxisCoordinates = $newYCoordinates;
    }

    /**
     * @param string $roverCoordinatesData
     * @return array
     * @throws RoverException
     */
    public function setCoordinates(string $roverCoordinatesData): array
    {
        $roverCoordinates = explode(RoverCommonConstants::AXES_DELIMITER, $roverCoordinatesData);
        if (count($roverCoordinates) != RoverCommonConstants::AXES_COUNT) {
            throw RoverException::axesCount();
        }

        if (!is_numeric($roverCoordinates[0]) || !is_numeric($roverCoordinates[1])) {
            throw RoverException::invalidAxesValuesTypeEntered($roverCoordinates);
        }

        return [$this->xAxisCoordinates, $this->yAxisCoordinates] = $roverCoordinates;
    }


    /**
     * @param string $direction
     * @throws RoverException
     */
    public function setDirection(string $direction): void
    {
        if (!in_array($direction, CardinalDirections::AS_ARRAY)) {
            throw RoverException::invalidDirection($direction);
        }
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}
