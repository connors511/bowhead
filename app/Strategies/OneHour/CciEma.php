<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class CciEma extends Strategy
{
	protected $strategy = 'cci_ema';

	protected function handle()
	{
        $ema8   = $this->ema_maker($this->data['close'], 8);
        $ema8p  = $this->ema_maker($this->data['close'], 8, 1);
        $ema28  = $this->ema_maker($this->data['close'], 28);
        $cci    = trader_cci($this->data['high'], $this->data['low'], $this->data['close'], 30);
        $cci    = array_pop($cci);

        if($ema8 > $ema28 && $ema8p < $ema28 && $cci > 0){
            return $this->side = self::BUY;
        }
        if ($ema8 < $ema28 && $ema8p > $ema28 && $cci < 0){
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}