<?php

namespace Bowhead\Strategies\OneMinute;

use Bowhead\Strategies\Strategy;

class EmaScalper extends Strategy
{
	protected $strategy = 'ema_scalper';

	protected function handle()
	{
        $red = $redp = $blue = $bluep = $green = $greenp = [];
        /**
         *  You have probably seen these large masses of EMA's
         *  On graphs looking like spider webs, they are used like this.
         *
         *  We are most interested when they all cross each other, so
         *  I compute the averages of them and it gives us numbers we
         *  can use.
         */
        $e1 = [2,3,4,5,6,7,8,9,10,11,12,13,14,15];      // red
        #$e2 = [17,19,21,23,25,27,29,31,33,35,37,39,41]; // blue
        $e3 = [44,47,50,53,56,59,62,65,68,71,74];       // green
        foreach ($e1 as $e) {
            $red[] = $this->ema_maker($this->data['close'], $e);
            $redp[] = $this->ema_maker($this->data['close'], $e, 1); // prior
        }
        $red_avg = (array_sum($red)/count($red));
        $redp_avg = (array_sum($redp)/count($redp));

        /**
         *  We use the blue lines for after we already have open
         *  positions, we can add to positions if the price touches
         *  the blue line
         */
        #foreach ($e2 as $e) {
        #    $blue[] = $this->ema_maker($this->data['close'], $e);
        #}
        #$blue_avg = (array_sum($blue)/count($blue));

        foreach ($e3 as $e) {
            $green[] = $this->ema_maker($this->data['close'], $e);
        }
        $green_avg = (array_sum($green)/count($green));

        if ($red_avg < $green_avg && $redp_avg > $green_avg){
            return $this->side = self::BUY;
        }
        if ($red_avg > $green_avg && $redp_avg < $green_avg){
            return $this->side = self::SELL;
        }

        return $this->side = self::HOLD;
	}
}