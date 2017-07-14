<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class EmaAdxMacd extends Strategy
{
	protected $strategy = 'ame_adx_macd';

	protected function handle()
	{
        $ema4  = $this->ema_maker($this->data['close'], 4);
        $ema4p = $this->ema_maker($this->data['close'], 4, 1);

        $ema10 = $this->ema_maker($this->data['close'], 10);
        $adx  = trader_adx($this->data['high'], $this->data['low'], $this->data['close'], 28);
        $adx  = array_pop($adx);

        $macd = $indicators->macd($this->pair, $this->data, 5, 10, 4);

        if ($ema4 < $ema10 && $ema4p > $ema10 && $macd < 0){
            return $this->side = self::BUY;
        }
        if ($ema4 > $ema10 && $ema4p < $ema10 && $macd > 0){
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}