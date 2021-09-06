<?php

namespace App\Models;

use App\Constants\Common\CardinalDirections;
use App\Constants\Rover\RoverCommonConstants;
use App\Exceptions\RoverException;
use App\Traits\AxesTrait;
use Illuminate\Database\Eloquent\Model;

class Rover extends Model
{
    use AxesTrait;

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
     * @var
     */
    private $roverLimitations;

    /**
     * @param array $roverLimitations
     */
    public function __construct(array $roverLimitations)
    {
        parent::__construct();
        $this->roverLimitations = $roverLimitations;
    }

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
     * @throws RoverException
     */
    public function setXAxisCoordinate(int $newXCoordinates): int
    {
        [$roverLimitationOnXAxis,] = $this->roverLimitations;
        if ($this->isOverAxisLimitation($roverLimitationOnXAxis, $newXCoordinates)) {
            throw RoverException::outOfGridMap();
        }
        return $this->xAxisCoordinates = $newXCoordinates;
    }

    /**
     * @param int $newYCoordinates
     * @return int
     * @throws RoverException
     */
    public function setYAxisCoordinate(int $newYCoordinates): int
    {
        [, $roverLimitationOnYAxis] = $this->roverLimitations;
        if ($this->isOverAxisLimitation($roverLimitationOnYAxis, $newYCoordinates)) {
            throw RoverException::outOfGridMap();
        }
        return $this->yAxisCoordinates = $newYCoordinates;
    }


    /**
     * @param string $roverCoordinatesData
     * @throws RoverException
     */
    public function setCoordinates(string $roverCoordinatesData): void
    {
        $roverCoordinates = explode(RoverCommonConstants::AXES_DELIMITER, $roverCoordinatesData);
        if (count($roverCoordinates) != RoverCommonConstants::AXES_COUNT) {
            throw RoverException::axesCount();
        }

        if (!is_numeric($roverCoordinates[0]) || !is_numeric($roverCoordinates[1])) {
            throw RoverException::invalidAxesValuesTypeEntered($roverCoordinates);
        }
        [$roverLimitationOnXAxis, $roverLimitationOnYAxis] = $this->roverLimitations;;

        $isXAxisPointIsOutOfRange = $this->isOverAxisLimitation($roverLimitationOnXAxis, $roverCoordinates[0]);
        $isYAxisPointIsOutOfRange = $this->isOverAxisLimitation($roverLimitationOnYAxis, $roverCoordinates[1]);

        if ($isXAxisPointIsOutOfRange || $isYAxisPointIsOutOfRange) {
            throw RoverException::outOfGridMap();
        }

        [$this->xAxisCoordinates, $this->yAxisCoordinates] = $roverCoordinates;
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
