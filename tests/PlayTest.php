<?php
use PHPUnit\Framework\TestCase;
include_once  'Game.php';
include_once 'GameInterface.php';
require 'play.php';

class PlayTest extends TestCase {

    public function testInstantiateObject()
    {
        $play = new Play();
        $this->assertIsObject($play);
    }

    public function testStart()
    {
        $play = new Play();        
        $play->start();
        $this->assertSame($play->getGameState(), play::STATE_PLAYING);
    }

    public function testCheckAliveStatus()
    {
        $play = new Play(); 
        $this->assertIsBool($play->checkAliveStatus());
    }
    public function testMessages() 
    {
        $play = new Play(); 
        $this->assertIsArray($play->getMessages());
    }
    public function testGetFarmDetails() 
    {
        $play = new Play(); 
        $this->assertIsArray($play->getFarmDetails(Play::FARMER_TYPE));
    }

}   