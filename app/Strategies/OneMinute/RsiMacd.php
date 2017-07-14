<?php

namespace Bowhead\Strategies\OneMinute;

use Bowhead\Strategies\Strategy;

class RsiMacd extends Strategy
{
	protected $strategy = 'rsi_macd';

	protected function handle()
	{
        $rsi = $this->indicators->rsi($pair, $data, 14); // 19 more accurate?
        /** custom macd - not using bowhead indicator macd*/
        $macd = trader_macd($data['close'], 24, 52, 18);
        $macd_raw = $macd[0];
        $signal   = $macd[1];
        $hist     = $macd[2];
        $macd = (array_pop($macd_raw) - array_pop($signal));

        /** rsi + macd */
        if ($macd > 0 && $rsi > 0) {
            return $this->side = self::BUY;
        }
        if ($macd < 0 && $rsi < 0) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}