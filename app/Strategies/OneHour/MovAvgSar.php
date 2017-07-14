<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class MovAvgSar extends Strategy
{
	protected $strategy = 'mov_avg_sar';

	protected function handle()
	{
        $sar  = $indicators->sar($this->pair, $this->data);

        $ema10   = $this->ema_maker($this->data['close'], 10);
        $ema10p  = $this->ema_maker($this->data['close'], 10, 1);
        $ema25   = $this->ema_maker($this->data['close'], 25);
        $ema50   = $this->ema_maker($this->data['close'], 50);

        if ($ema10 > $ema25 && $ema10 > $ema50 && $ema10p < $ema25 && $ema10p < $ema50 && $sar > 0) {
            return $this->side = self::BUY;
        }
        if ($ema10 < $ema25 && $ema10 < $ema50 && $ema10p > $ema25 && $ema10p > $ema50 && $sar < 0) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}