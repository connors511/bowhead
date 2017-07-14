<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class EmaStochRsi extends Strategy
{
	protected $strategy = 'ema_stoch_rsi';

	protected function handle()
	{
        $ema5   = $this->ema_maker($this->data['close'], 5);
        $ema5p  = $this->ema_maker($this->data['close'], 5, 1);
        $ema10  = $this->ema_maker($this->data['close'], 10);
        #$ema10p = $this->ema_maker($this->data['close'], 10, 1);

        $stoch = trader_stoch($this->data['high'], $this->data['low'], $this->data['close'], 14, 3, TRADER_MA_TYPE_SMA, 3, TRADER_MA_TYPE_SMA);
        $slowk = $stoch[0];
        $slowd = $stoch[1];

        $slowk1 = array_pop($slowk);
        $slowkp = array_pop($slowk);
        $slowd1 = array_pop($slowd);
        $slowdp = array_pop($slowd);

        $k_up = $d_up = false;
        if ($slowkp < $slowk1) {
            $k_up = true;
        }
        if ($slowdp < $slowd1) {
            $d_up = true;
        }
        $pointed_down = $pointed_up = false;
        if ($slowk < 80 && $slowd < 80 && $k_up && $d_up) {
            $pointed_up = true;
        }
        if ($slowk > 20 && $slowd > 20 && !$k_up && !$d_up) {
            $pointed_down = true;
        }

        $rsi = trader_rsi ($this->data['close'], 14);
        $rsi = array_pop($rsi);

        if ($ema5 >= $ema10 && $ema5p < $ema10 && $rsi > 50 && $pointed_up) {
            return $this->side = self::BUY;
        }
        if ($ema5 <= $ema10 && $ema5p > $ema10 && $rsi < 50 && $pointed_down) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}