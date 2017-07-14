<?php

namespace Bowhead\Strategies;

class PessimisticCombinationStrategy extends Strategy
{
	public function handle()
	{
		// Returns BUY or SELL, only if the combined
		// strategies does not contain both BUY and SELL.
		// i.e. SELL + HOLD => SELL
		//      BUY + HOLD => BUY
		//      BUY + SELL => HOLD
		// If all strategies agree, that'll be returned
		return collect($this->strategies)
					->map(function($strategy) {
						return with(new $strategy($this->pair, $this->data))->handle();
					})
					->reject(function($value) {
						return $value === self::HOLD;
					})
					->unique()
					->pipe(function($collection) {
						return $collection->count() == 1 ?
								$collection->first() :
								self::HOLD;
					});
	}
}