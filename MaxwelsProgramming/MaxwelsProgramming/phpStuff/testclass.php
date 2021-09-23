<?php


class GuessingGame {

    private $zahl;

    public $lastGuess;

    public function __construct() {
        $this->zahl =  123 /**random */
    }

    public function get($identifier): mixed {
        return $this->$identifier;
    }

    public function play($guess) {
        $this->lastGuess = $guess;

        if ($guess === $this->zahl) {
            return true;
        } else {
            return false;
        }
    }

}

// =========================================

$spiel = new GuessingGame();


$won = false;
while (!$won)  {

    $winNumber = $spiel->get('zahl');

    $won = $spiel->play();




    echo('Dein letzter Versuch war ' . $spiel->get('lastGuess'))
}