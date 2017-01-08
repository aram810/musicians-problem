<?php

function getAndRemove(&$array) {
	$i = array_rand($array);
	$number = $array[$i];

	unset($array[$i]);

	return $number;
}

class Musician {
	public $instrument;

	public function __construct($instrument) {
		$this->instrument = $instrument;
	}

	public function tryGame() {
		$observedBoxImage = $this->instrument;

		for ($i = 0; $i < 5; ++$i) {
			$innerInstrument = Boxes::getInstrumentByImage($observedBoxImage);

			if ($innerInstrument === $this->instrument) {
				return true;
			} else {
				$observedBoxImage = $innerInstrument;
			}
		}

		return false;
	}
}

class Musicians {
	/**
	 * @var Musician[]
	 */
	public static $musicians = [];

	public static function areReady() {
		return !empty(self::$musicians);
	}

	public static function prepare() {
		self::reset();

		$instruments = range(0, 9);

		for ($i = 0; $i < 10; ++$i) {
			$instrument = getAndRemove($instruments);

			self::$musicians[$i] = new Musician($instrument);
		}
	}

	private static function reset() {
		self::$musicians = [];
	}
}

class Box {
	public $innerInstrument;

	public $instrumentImage;

	/**
	 * Box constructor.
	 *
	 * @param $innerInstrument
	 * @param $instrumentImage
	 */
	public function __construct($innerInstrument, $instrumentImage) {
		$this->innerInstrument = $innerInstrument;
		$this->instrumentImage = $instrumentImage;
	}


}

class Boxes {
	/**
	 * @var Box[]
	 */
	public static $boxes = [];

	public static function getInstrumentByImage($image) {
		foreach (self::$boxes as $box) {
			if ($box->instrumentImage === $image) {
				return $box->innerInstrument;
			}
		}

		return false;
	}

	public static function fillWithInstruments() {
		self::reset();

		$numbers = range(0, 9);

		for ($image = 0; $image < 10; ++$image) {
			$instrument = getAndRemove($numbers);

			self::addBox(new Box($instrument, $image));
		}
	}

	private static function addBox(Box $box) {
		self::$boxes[] = $box;
	}

	private static function reset() {
		self::$boxes = [];
	}
}

class Game {
	private static function try() {
		Boxes::fillWithInstruments();
		Musicians::prepare();

		foreach (Musicians::$musicians as $musician) {
			if (!$musician->tryGame()) {
				return false;
			}
		}

		return true;
	}

	public static function getProbability($repetitionNumber = 10000) {
		$counter = 0;

		for ($i = 0; $i < $repetitionNumber; ++$i) {
			if (self::try()) {
				$counter += 1;
			}
		}

		return $counter/$repetitionNumber;
	}
}

echo Game::getProbability();