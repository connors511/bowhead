<?php

namespace Bowhead\Strategies\ThirtyMinute;

use Bowhead\Strategies\Strategy;

class SarAwesome extends Strategy
{
	protected $strategy = 'sar_awesome';

	protected function handle()
	{
        $sar  = $this->indicators->sar($this->pair, $this->data);
        $ema5 = $this->ema_maker($this->data['close'], 5);
        $ao   = $this->indicators->awesome_oscillator($this->pair, $this->data);
        $price = array_pop($this->data['close']);

        if ($sar < 0 && $ao > 0 && $ema5 < $price) {
            return $this->side = self::BUY;
        }
        if ($sar > 0 && $ao < 0 && $ema5 > $price) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}