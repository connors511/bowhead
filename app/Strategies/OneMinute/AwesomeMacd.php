<?php

namespace Bowhead\Strategies\OneMinute;

use Bowhead\Strategies\Strategy;

class AwesomeMacd extends Strategy
{
	protected $strategy = 'awesome_macd';

	protected function handle()
	{
        $ao     = $this->indicators->awesome_oscillator($pair, $data);
        $macd   = $this->indicators->macd($pair, $data);
        /** Awesome + MACD */
        if ($macd < 0 && $ao < 0) {
            return $this->side = self::SELL;
        }
        if ($macd > 0 && $ao > 0) {
            return $this->side = self::LONG;
        }
        return self::HOLD;
	}
}