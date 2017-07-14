<?php

namespace Bowhead\Strategies\OneMinute;

use Bowhead\Strategies\Strategy;

class SarRsi extends Strategy
{
	protected $strategy = 'sar_rsi';

	protected function handle()
	{
        $fsar = $this->indicators->fsar($pair, $data); // custom sar for forex
        $rsi  = $this->indicators->rsi($pair, $data, 14); // 19 more accurate?

        if ($fsar == -1 && $rsi < 0) {
            return $this->side = self::SELL;
        } elseif ($fsar == 1 && $rsi > 0) {
            return $this->side = self::BUY;
        }

        return $this->side = self::HOLD;
	}
}