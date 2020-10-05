<?php

interface GameInterface {
    //When game over keep this state
    const STATE_GAMEOVER = 'gameOver';
    //When game started keep this state
    const STATE_PLAYING = 'playing';
    //Name set to Farmer
    const FARMER_TYPE='Farmer';
    //Name set to Cows
    const COWS_TYPE='Cows';
    //Name set to Bunnies
    const BUNNIES_TYPE='Bunnies';
    //Total Turn count
    const TURN=50;
    //Start the game
    public function start();

}