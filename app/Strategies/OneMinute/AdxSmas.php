<?php

namespace Bowhead\Strategies\OneMinute;

use Bowhead\Strategies\Strategy;

class AsxSmas extends Strategy
{
	protected $strategy = 'asx_smas';

	protected function handle()
	{
        $adx         = $this->indicators->adx($pair, $data);

        $_sma6       = trader_sma($data['close'], 6);
        $sma6        = array_pop($_sma6);
        $prior_sma6  = array_pop($_sma6);

        $_sma40      = trader_sma($data['close'], 40);
        $sma40       = array_pop($_sma40);
        $prior_sma40 = array_pop($_sma40);
        /** have the lines crossed? */
        // https://www.tradingview.com/x/kH5sdnHR/
        $sixCross   = (($prior_sma6 < $sma40 && $sma6 > $sma40) ? 1 : 0);
        $fortyCross = (($prior_sma40 < $sma6 && $sma40 > $sma6) ? 1 : 0);

        if ($adx > 0 && $sixCross == 1) {
            return $this->side = self::SELL;
        }
        if ($adx > 0 && $fortyCross == 1) {
            return $this->side = self::BUY;
        }
        return $this->side = self::HOLD;
	}
}