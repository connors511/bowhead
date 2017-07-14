<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class BreakoutMa extends Strategy
{
	protected $strategy = 'breakout_ma';

	protected function handle()
	{
        $sma20_low  = $this->sma_maker($this->data['low'], 20);
        $ema34      = $this->ema_maker($this->data['close'], 34);
        $adx  = trader_adx($this->data['high'], $this->data['low'], $this->data['close'], 13);
        $adx  = array_pop($adx);

        if ($ema34 > $sma20_low && $adx > 25) {
            return $this->side = self::BUY;
        }
        if ($ema34 < $sma20_low && $adx > 25) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}