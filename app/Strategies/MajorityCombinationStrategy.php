<?php

namespace Bowhead\Strategies;

class MajorityCombinationStrategy extends Strategy
{
	public function handle()
	{
    // Whichever the majority of strategies agree on
    // is returned. Best result with an uneven number
    // of stretegies
		return collect($this->strategies)
					->map(function($strategy) {
						return with(new $strategy($this->pair, $this->data))->handle();
					})
					->mode()
					->first();
	}
}