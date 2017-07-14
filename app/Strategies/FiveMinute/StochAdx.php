<?php

namespace Bowhead\Strategies\FiveMinute;

use Bowhead\Strategies\Strategy;

class StochAdx extends Strategy
{
	protected $strategy = 'stoch_adx';

	protected function handle()
	{
        $recentData2 = $this->data['close'];
        $curr  = array_pop($recentData2);
        $prev  = array_pop($recentData2);
        $prior = array_pop($recentData2);
        $bullish = $bearish = false;
        if ($curr > $prev && $prev > $prior) {
            $bullish = true; // last two candles were bullish
        }
        if ($curr < $prev && $prev < $prior) {
            $bearish = true; // last two candles were bearish
        }
        $adx   = $this->indicators->adx($pair, $data);
        $stoch = $this->indicators->stoch($pair, $data);

        if ($adx == -1 && $stoch < 0 && $bearish) {
        	return $this->side = self::SELL;
        } elseif ($adx == 1 && $stoch > 0 && $bullish) {
            return $this->side = self::BUY;
        }

        return $this->side = self::HOLD;
	}
}