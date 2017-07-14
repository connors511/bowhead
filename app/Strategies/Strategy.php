<?php

namespace Bowhead\Strategies;

class Strategy
{
	protected $indicators;

	protected $strategy;
	protected $side;

	const SELL = 'short';
	const HOLD = false;
	const BUY = 'long'; 

	public function __construct($pair = null, $data = null)
	{
		$this->indicators = new Indicators();

		$this->pair = $pair;
		$this->data = $data;
	}

	protected abstract function handle() {}

	public function getSide()
	{
		return $this->side ?? $this->handle();
	}

	public function getStrategy()
	{
		return $this->strategy;
	}

	/**
     * @param $data
     * @param $period
     *
     * @return mixed
     *
     *  util function, lots of custom EMA's here.
     */
    private function ema_maker($data, $period, $prior=false)
    {
        $ema = trader_ema($data, $period);
        $ema = @array_pop($ema) ?? 0;
        $ema_prior = @array_pop($ema) ?? 0;
        return ($prior ? $ema_prior : $ema);
    }

    /**
     * @param      $data
     * @param      $period
     * @param bool $prior
     *
     * @return mixed
     */
    private function sma_maker($data, $period, $prior=false)
    {
        $ema = trader_sma($data, $period);
        $ema = @array_pop($ema) ?? 0;
        $ema_prior = @array_pop($ema) ?? 0;
        return ($prior ? $ema_prior : $ema);
    }

    /**
     * @param      $data
     * @param      $period
     * @param bool $prior
     *
     * @return mixed
     */
    private function ma_maker($data, $period, $prior=false)
    {
        $ema = trader_ma($data, $period);
        $ema = @array_pop($ema) ?? 0;
        $ema_prior = @array_pop($ema) ?? 0;
        return ($prior ? $ema_prior : $ema);
    }
}