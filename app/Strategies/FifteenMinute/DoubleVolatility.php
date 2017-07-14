<?php

namespace Bowhead\Strategies\FifteenMinute;

use Bowhead\Strategies\Strategy;

class DoubleVolatility extends Strategy
{
	protected $strategy = 'double_volatility';

	protected function handle()
	{
        $rsi = trader_rsi ($this->data['close'], 11);
        $rsi = array_pop($rsi);

        $sma20_high = $this->sma_maker($this->data['high'], 20);
        $sma20_low  = $this->sma_maker($this->data['low'], 20);
        $sma5_high  = $this->sma_maker($this->data['high'], 5);
        #$sma5_low   = $this->sma_maker($this->data['low'], 5);

        if ($sma5_high > $sma20_high && $rsi > 65) {
            return $this->side = self::BUY;
        }
        if ($sma5_high < $sma20_low && $rsi < 35) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}