<?php

namespace Bowhead\Strategies\FiveMinute;

use Bowhead\Strategies\Strategy;

class AdxMomentum extends Strategy
{
	protected $strategy = 'adx_momentum';

	protected function handle()
	{
        $adx  = trader_adx($this->data['high'], $this->data['low'], $this->data['close'], 25);
        $adx  = array_pop($adx);
        $mom  = trader_mom($this->data['close'], 14);
        $mom  = array_pop($mom);
        $fsar = $indicators->fsar($this->pair, $this->data);

        if ($adx > 25 && $mom > 100 && $fsar > 0) {
            return $this->side = self::BUY;
        }
        if ($adx > 25 && $mom < 100 && $fsar < 0) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}