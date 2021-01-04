<?php 

namespace App\Services;

/**
 * 
 */
class TimeService
{
	protected $now;

	function __construct(int $timestamp=0)
	{
		if ($timestamp) {
			$this->now = $timestamp;
		} else {
			$this->now = time();
		}
	}

	public function timeLeft($seconds)
	{
		return $seconds - $this->now;
	}

	public function timeSince($seconds)
	{
		return $this->now - $seconds;
	}

	public function lapses($units, string $measure='seconds') :array
	{
		if ($measure != 'seconds') {
			$units = $this->toSeconds($units, $measure);
		}

		if ($units <= 0) {
			throw new Exception("Units of time can't be negative values", 1);
		}

		if ($units > $this->now) {
			$lapse = $this->timeLeft($units);
			$period = 'future';
		} else {
			$lapse = $this->timeSince($units);
			$period = 'past';
		}

		$date = date('Y-m-d H:i:s', $units);
		$time = $this->globalConvert($lapse);

		return compact('time','date','period');
	}

	public function globalConvert($units, string $measure='seconds') :array
	{
		return [
			'seconds' => $this->toSeconds($units, $measure),
			'minutes' => $this->toMinutes($units, $measure),
			'hours' => $this->toHours($units, $measure),
			'days' => $this->toDays($units, $measure),
			'weeks' => $this->toWeeks($units, $measure),
			'months' => $this->toMonths($units, $measure),
			'years' => $this->toyears($units, $measure)
		];
	}

	public function toSeconds($units, string $measure='seconds') :float
	{
		switch ($measure) {
			case 'seconds' 	: return $units;
			case 'minutes' 	: return $units*60;
			case 'hours' 	: return $units*(60**2);
			case 'days'		: return $units*((60**2)*24);
			case 'weeks'	: return $units*((60**2)*24*7);
			case 'months'	: return $units*((60**2)*24*30);
			case 'years'	: return $units*((60**2)*24*365);
			default: break;
		}

		throw new \Exception("Not valid time unit: {$measure}", 1);
	}

	public function toMinutes($units, string $measure='seconds') :float
	{
		switch ($measure) {
			case 'seconds' 	: return $units/60;
			case 'minutes' 	: return $units;
			case 'hours' 	: return $units*60;
			case 'days'		: return $units*(60*24);
			case 'weeks'	: return $units*(60*24*7);
			case 'months'	: return $units*(60*24*30);
			case 'years'	: return $units*(60*24*365);
			default: break;
		}

		throw new \Exception("Not valid time unit: {$measure}", 1);
	}

	public function toHours($units, string $measure='seconds') :float
	{
		switch ($measure) {
			case 'seconds' 	: return $units/(60**2);
			case 'minutes' 	: return $units/60;
			case 'hours' 	: return $units;
			case 'days'		: return $units*24;
			case 'weeks'	: return $units*24*7;
			case 'months'	: return $units*24*30;
			case 'years'	: return $units*24*365;
			default: break;
		}

		throw new \Exception("Not valid time unit: {$measure}", 1);
	}

	public function toDays($units, string $measure='seconds') :float
	{
		switch ($measure) {
			case 'seconds' 	: return $units/(24*(60**2));
			case 'minutes' 	: return $units/(24*60);
			case 'hours' 	: return $units/(24);
			case 'days'		: return $units;
			case 'weeks'	: return $units*7;
			case 'months'	: return $units*30;
			case 'years'	: return $units*365;
			default: break;
		}

		throw new \Exception("Not valid time unit: {$measure}", 1);
	}

	public function toWeeks($units, string $measure='seconds') :float
	{
		switch ($measure) {
			case 'seconds' 	: return $units/(7*24*(60**2));
			case 'minutes' 	: return $units/(7*24*60);
			case 'hours' 	: return $units/(7*24);
			case 'days'		: return $units/(7);
			case 'weeks'	: return $units;
			case 'months'	: return $units*4.3;
			case 'years'	: return $units*4.3*12;
			default: break;
		}

		throw new \Exception("Not valid time unit: {$measure}", 1);
	}

	public function toMonths($units, string $measure='seconds') :float
	{
		switch ($measure) {
			case 'seconds' 	: return $units/(30*24*(60**2));
			case 'minutes' 	: return $units/(30*24*60);
			case 'hours' 	: return $units/(30*24);
			case 'days'		: return $units/(30);
			case 'weeks'	: return $units/(4.3);
			case 'months'	: return $units;
			case 'years'	: return $units*12;
			default: break;
		}

		throw new \Exception("Not valid time unit: {$measure}", 1);
	}

	public function toYears($units, string $measure='seconds') :float
	{
		switch ($measure) {
			case 'seconds' 	: return $units/(365*24*(60**2));
			case 'minutes' 	: return $units/(365*24*60);
			case 'hours' 	: return $units/(365*24);
			case 'days'		: return $units/(365);
			case 'weeks'	: return $units/(12*4.3);
			case 'months'	: return $units/(12);
			case 'years'	: return $units;
			default: break;
		}

		throw new \Exception("Not valid time unit: {$measure}", 1);
	}
}