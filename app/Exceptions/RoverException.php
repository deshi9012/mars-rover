<?php

namespace App\Exceptions;

use App\Constants\Rover\RoverExceptionConstants;
use App\Constants\Rover\RoverStringConstants;

class RoverException extends \Exception
{

    /**
     * @return RoverException
     */
    public static function axesCount(): RoverException
    {
        return new self(
            RoverStringConstants::INVALID_AXES_COUNT_EXCEPTION_MESSAGE,
            RoverExceptionConstants::INVALID_AXES_DATA
        );
    }

    /**
     * @param array $axesData
     * @return RoverException
     */
    public static function invalidAxesValuesTypeEntered(array $axesData): RoverException
    {
        return new self(
            RoverStringConstants::INVALID_AXES_VALUES_TYPE_EXCEPTION_MESSAGE . serialize($axesData),
            RoverExceptionConstants::INVALID_AXES_DATA
        );
    }

    /**
     * @param $direction
     * @return RoverException
     */
    public static function invalidDirection($direction): RoverException
    {
        return new self(
            RoverStringConstants::INVALID_DIRECTION_EXCEPTION_MESSAGE . serialize($direction),
            RoverExceptionConstants::INVALID_DIRECTION_DATA
        );
    }

    /**
     * @param $command
     * @return RoverException
     */
    public static function invalidRotationCommand($command): RoverException
    {
        return new self(
            RoverStringConstants::INVALID_ROTATION_COMMAND_EXCEPTION_MESSAGE . serialize($command),
            RoverExceptionConstants::INVALID_COMMAND_DATA
        );
    }

    /**
     * @return RoverException
     */
    public static function outOfGridMap(): RoverException
    {
        return new self(
            RoverStringConstants::OUT_OF_GRID_MAP_EXCEPTION_MESSAGE,
            RoverExceptionConstants::OUT_OF_GRID_MAP
        );
    }
}
