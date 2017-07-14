<?php

namespace Bowhead\Strategies\OneHour;

use Bowhead\Strategies\Strategy;

class Base150 extends Strategy
{
	protected $strategy = 'base_150';

	protected function handle()
	{
        if (count($this->data['close']) < 365) {
            throw new \Exception("need larger data set. (365 min)");
        }

        $ma6   = $this->ma_maker($this->data['close'], 6);
        $ma6p  = $this->ma_maker($this->data['close'], 6, 1);
        $ma35  = $this->ma_maker($this->data['close'], 35);
        $ma35p = $this->ma_maker($this->data['close'], 35, 1);

        $ma150 = $this->ma_maker($this->data['close'], 150);
        $ma365 = $this->ma_maker($this->data['close'], 365);

        if (   $ma6 > $ma150
            && $ma6 > $ma365
            && $ma35 > $ma150
            && $ma35 > $ma365
            && $ma6p < $ma150
            && $ma6p < $ma365
            && $ma35p < $ma150
            && $ma35p < $ma365) {
            return $this->side = self::BUY;
        }
        if (   $ma6 < $ma150
            && $ma6 < $ma365
            && $ma35 < $ma150
            && $ma35 < $ma365
            && $ma6p > $ma150
            && $ma6p > $ma365
            && $ma35p > $ma150
            && $ma35p > $ma365) {
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}