
## Landing Rover Task
###1. Pull the repository
###2. Execute `composer install`
###3. Enter `php artisan landing:start` to start Landing mission.
###4. The CLI should output: `Enter grid size. Eg. 5x5:`.And you have to enter length of 'x' axis and 'y' axis in the following pattern: {xAxisSize}x{yAxisSize}. 
###5. The CLI should output: `Enter rover coordinates. (Eg. 1x2):` .And you have to enter rover coordinates in the following pattern: {xCoordinates}x{yCoordinates}. 
###6. The CLI should output: `Enter rover direction. (N for North, W for West, S for South and E for East):` .And you have to enter rover initial direction with single letter: N, W, E or S. 
###6. The CLI should output: `Enter moving commands. (Eg. LMLMLMLMM):` .And you have to enter a list of rover moving and rotation commands using following letters: L-rotate to left, R-rotate to right, M-move forward.

##Note!
###If on some step landing mission throws Error you have to re-start landing again. 

