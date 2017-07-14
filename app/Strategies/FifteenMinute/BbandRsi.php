<?php

namespace Bowhead\Strategies\FifteenMinute;

use Bowhead\Strategies\Strategy;

class BbandRsi extends Strategy
{
	protected $strategy = 'bband_rsi';

	protected function handle()
	{
        $rsi    = $this->indicators->rsi($this->pair, $this->data, 11);
        $bbands = $this->indicators->bollingerBands($this->pair, $this->data, 20);

        if ($rsi > 70 && $bbands == -1) {
            return $this->side = self::BUY;
        }
        if ($rsi < 30 && $bbands == 1) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}