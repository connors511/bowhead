<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class SmaStochRsi extends Strategy
{
	protected $strategy = 'sma_stoch_rsi';

	protected function handle()
	{
        $price  = array_pop($this->data['close']);
        $sma150  = $this->sma_maker($this->data['close'], 150);
        $stoch = trader_stoch($this->data['high'], $this->data['low'], $this->data['close'], 8, 3, TRADER_MA_TYPE_SMA, 3, TRADER_MA_TYPE_SMA);
        $slowk = $stoch[0];
        $slowd = $stoch[1];

        $slowk = array_pop($slowk);
        $slowd = array_pop($slowd);

        $rsi = trader_rsi ($this->data['close'], 3);
        $rsi = array_pop($rsi);

        if ($price > $sma150 && $rsi < 20 && $slowk > 70 && $slowk > $slowd) {
            return $this->side = self::BUY;
        }
        if ($price < $sma150 && $rsi > 80 && $slowk > 70 && $slowk < $slowd) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}