<?php

namespace Bowhead\Strategies\Majorities;

use Bowhead\Strategies\WeightedCombinationStrategy;

class WeightedCombinationExample extends WeightedCombinationStrategy
{
  protected $strategy = 'weight_combine_ex';

  protected $strategies = [
    \Bowhead\Strategies\OneMinute\SarStoch::class => 1.0,
    \Bowhead\Strategies\OneMinute\AwesomeMacd::class => 2.5,
    \Bowhead\Strategies\OneMinute\AdxSmas::class => 4.0,
  ];
}