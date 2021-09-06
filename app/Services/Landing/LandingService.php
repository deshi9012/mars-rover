<?php

namespace App\Services\Landing;

use App\Constants\Common\CardinalDirections;
use App\Constants\Rover\RoverCommonConstants;
use App\Constants\Rover\RoverRotationCommands;
use App\Exceptions\RoverException;
use App\Interfaces\LandingMissionInterface;
use App\Models\Rover;
use App\Traits\AxesTrait;

class LandingService implements LandingMissionInterface
{

    use AxesTrait;

    /**
     * @var Rover
     */
    private $rover;

    /**
     * @param Rover $rover
     */
    public function __construct(Rover $rover)
    {
        $this->rover = $rover;
    }

    /**
     * @throws RoverException
     */
    public function moveForward(): void
    {
        $roverDirection = $this->rover->getDirection();
        [$roverXCoordinates, $roverYCoordinates] = $this->rover->getCoordinates();

        switch ($roverDirection) {
            case CardinalDirections::NORTH:
                $this->rover->setYAxisCoordinate(++$roverYCoordinates);
                break;
            case CardinalDirections::EAST:
                $this->rover->setXAxisCoordinate(++$roverXCoordinates);
                break;
            case CardinalDirections::SOUTH:
                $this->rover->setYAxisCoordinate(--$roverYCoordinates);
                break;
            case CardinalDirections::WEST:
                $this->rover->setXAxisCoordinate(--$roverXCoordinates);
                break;
            default:
                throw RoverException::invalidDirection($roverDirection);
        }
    }

    /**
     * @throws RoverException
     */
    public function rotateLeft(): void
    {
        $roverDirection = $this->rover->getDirection();

        switch ($roverDirection) {
            case CardinalDirections::NORTH:
                $this->rover->setDirection(CardinalDirections::WEST);
                break;
            case CardinalDirections::WEST:
                $this->rover->setDirection(CardinalDirections::SOUTH);
                break;
            case CardinalDirections::SOUTH:
                $this->rover->setDirection(CardinalDirections::EAST);
                break;
            case CardinalDirections::EAST:
                $this->rover->setDirection(CardinalDirections::NORTH);
                break;
            default:
                throw RoverException::invalidDirection($roverDirection);
        }
    }

    /**
     * @throws RoverException
     */
    public function rotateRight(): void
    {
        $roverDirection = $this->rover->getDirection();
        switch ($roverDirection) {
            case CardinalDirections::NORTH:
                $this->rover->setDirection(CardinalDirections::EAST);
                break;
            case CardinalDirections::EAST:
                $this->rover->setDirection(CardinalDirections::SOUTH);
                break;
            case CardinalDirections::SOUTH:
                $this->rover->setDirection(CardinalDirections::WEST);
                break;
            case CardinalDirections::WEST:
                $this->rover->setDirection(CardinalDirections::NORTH);
                break;
            default:
                throw RoverException::invalidDirection($roverDirection);
        }
    }

    /**
     * @param string $roverDirection
     * @throws RoverException
     */
    public function rotateRover(string $roverDirection): void
    {
        if ($roverDirection == RoverRotationCommands::LEFT) {
            $this->rotateLeft();
        } else {
            $this->rotateRight();
        }
    }

    /**
     * @param string $commands
     * @throws RoverException
     */
    public function executeCommands(string $commands): void
    {
        $separatedCommands = str_split($commands);
        foreach ($separatedCommands as $command) {
            switch ($command) {
                case RoverRotationCommands::MOVE_FORWARD:
                    $this->moveForward();
                    break;
                case RoverRotationCommands::LEFT:
                case RoverRotationCommands::RIGHT:
                    $this->rotateRover($command);
                    break;
                default:
                    throw RoverException::invalidRotationCommand($command);
            }
        }
    }

    /**
     * @return string
     */
    public function getFinalCoordinatesAndDirection(): string
    {
        [$roverXCoordinates, $roverYCoordinates] = $this->rover->getCoordinates();
        $roverDirection = $this->rover->getDirection();

        return $roverXCoordinates . RoverCommonConstants::AXES_DELIMITER . $roverYCoordinates . ' ' . $roverDirection;
    }
}
