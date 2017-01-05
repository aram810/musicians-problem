<?php

class Musician {
	public $instrument;

	public function __construct($instrument) {
		$this->instrument = $instrument;
	}

	public function tryGame($instruments) {
		$current_index = $this->instrument;

		for ($i = 0; $i < 5; ++$i) {
			if ($instruments[$current_index] === $this->instrument) {
				return true;
			} else {
				$current_index = $instruments[$current_index];
			}
		}

		return false;
	}
}

function getAndRemove(&$array) {
	$i = array_rand($array);
	$number = $array[$i];

	unset($array[$i]);

	return $number;
}

function startGame() {
	$musicians = getMusicians();
	$instruments = getInstruments();

	foreach ($musicians as $musician) {
		if (!$musician->tryGame($instruments)) {
			return false;
		}
	}

	return true;
}

function getInstruments() {
	$numbers = range(0, 9);

	for ($i = 0; $i < 10; ++$i) {
		$instruments[$i] = getAndRemove($numbers);
	}

	return $instruments;
}

/**
 * @return Musician[]
 */
function getMusicians() {
	$instruments = getInstruments();

	for ($i = 0; $i < 10; ++$i) {
		$instrument = getAndRemove($instruments);

		$musicians[$i] = new Musician($instrument);
	}

	return $musicians;
}

$counter = 0;

for ($i = 0; $i < 10000; ++$i) {
	if (startGame()) {
		++$counter;
	}
}

echo $counter / 100 . '%';