<?php

namespace App\Console\Commands;

use App\Services\RoverMover\RoverMoverService;
use Illuminate\Console\Command;
use App\Models\GridMap;
use App\Models\Rover;

class NavigateRover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'navigation:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle():void
    {
        $gridData = $this->ask('Enter grid size. Eg. 5x5');

        $grid = new GridMap();
        $grid->setAxesLength($gridData);

        $roverCoordinates = $this->ask('Enter rover coordinates. (Eg. 1x2)');
        $roverDirection = $this->ask('Enter rover direction. (N for North, W for West, S for South and E for East)');

        $roverModel = new Rover();
        $roverModel->setCoordinates($roverCoordinates);
        $roverModel->setDirection($roverDirection);

        $roverNavigationCommands = $this->ask('Enter moving commands. (Eg. LMLMLMLMM)');

        $landingMission = new RoverMoverService($roverModel, $grid);

        $landingMission->executeCommands($roverNavigationCommands);

        $this->info($landingMission->getFinalCoordinatesAndDirection());
    }
}
