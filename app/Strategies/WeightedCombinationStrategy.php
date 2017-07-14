<?php

namespace Bowhead\Strategies;

class WeightedCombinationStrategy extends Strategy
{
	public function handle()
	{
		return collect($this->strategies)
					->map(function($weight, $strategy) {
						return [
							'strat' => with(new $strategy($this->pair, $this->data))->handle(),
							'weight' => $weight
						];
					})
					->groupBy('strat')
					->map(function ($strat, $entries) {
						return collect($entries)->sum('weight');
					})
					->map(function ($strat, $weight) {
						return [
							'strat' => $strat,
							'weight' => $weight
						];
					})
					->sortByDesc('strat')
					->first()
					->get('strat');
	}
}