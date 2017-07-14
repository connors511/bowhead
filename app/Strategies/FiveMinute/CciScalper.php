<?php

namespace Bowhead\Strategies\FiveMinute;

use Bowhead\Strategies\Strategy;

class CciScalper extends Strategy
{
	protected $strategy = 'cci_scalper';

	protected function handle()
	{
        // 128 is our default period, so we need to verify it is bigger
        if (count($this->data['close']) < 200) {
            throw new Exception("need larger data set. (200 min)");
        }

        $cci = trader_cci($this->data['high'], $this->data['low'], $this->data['close'], 200);
        $cci = array_pop($cci);

        $ema10 = $this->ema_maker($this->data['close'], 10);
        $ema21 = $this->ema_maker($this->data['close'], 21);
        $ema50 = $this->ema_maker($this->data['close'], 50);

        if ($cci > 0 && $ema10 > $ema21 && $ema10 > $ema50) {
            return $this->side = self::BUY;
        }
        if ($cci < 0 && $ema10 < $ema21 && $ema10 < $ema50) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}