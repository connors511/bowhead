<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class Momentum extends Strategy
{
	protected $strategy = 'momentum';

	protected function handle()
	{
        $price  = array_pop($this->data['close']);
        $sma21  = $this->sma_maker($this->data['close'], 21);
        $sma21p = $this->sma_maker($this->data['close'], 21, 1);
        $sma11  = $this->sma_maker($this->data['close'], 11);
        $mom    = trader_mom($this->data['close'], 30);
        $mom    = array_pop($mom);
        $rsi    = $indicators->rsi($this->pair, $this->data, 14);

        if ($rsi > 0 && $mom > 100 && $sma11 > $sma21 && $price > $sma21 && $price > $sma11) {
            return $this->side = self::BUY;
        }
        if ($rsi < 0 && $mom > 100 && $sma11 < $sma21 && $price < $sma21 && $price < $sma11) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}