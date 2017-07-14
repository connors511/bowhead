<?php

namespace Bowhead\Strategies\OneMinute;

use Bowhead\Strategies\Strategy;

class SarStoch extends Strategy
{
	protected $strategy = 'sar_stoch';

	protected function handle()
	{
        $fsar   = $this->indicators->fsar($this->pair, $this->data); // custom sar for forex
        $stoch  = $this->indicators->stoch($this->pair, $this->data);
        $stochf = $this->indicators->stochf($this->pair, $this->data);
        $stochs = (($stoch == -1 || $stochf == -1) ? -1 : ( ($stoch == 1 || $stochf == 1) ? 1 : 0) );

        if ($fsar == -1 && ($stoch == -1 || $stochf == -1)) {
            return $this->side = self::SELL;
        } elseif ($fsar == 1 && ($stoch == 1 || $stochf == 1)) {
            return $this->side = self::BUY;
        }
        return $this->side = self::HOLD;
	}
}