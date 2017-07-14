<?php

namespace Bowhead\Strategies\Majorities;

use Bowhead\Strategies\MajorityCombinationStrategy;

class MajorityCombinationExample extends MajorityCombinationStrategy
{
	protected $strategy = 'major_combine_ex';

	protected $strategies = [
		\Bowhead\Strategies\OneMinute\SarStoch::class,
		\Bowhead\Strategies\OneMinute\AwesomeMacd::class,
		\Bowhead\Strategies\OneMinute\AdxSmas::class,
	];
}