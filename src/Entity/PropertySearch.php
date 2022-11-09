<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {
	
	private ?int $maxPrice = null;
	
	#[Assert\Range(min: 10)]
	private ?int $minSurface = null;
	
	/**
	 * @return int|null
	 */
	public function getMaxPrice(): ?int {
		return $this->maxPrice;
	}
	
	/**
	 * @param int $maxPrice
	 *
	 * @return PropertySearch
	 */
	public function setMaxPrice( int $maxPrice ): PropertySearch {
		$this->maxPrice = $maxPrice;
		
		return $this;
	}
	
	/**
	 * @return int|null
	 */
	public function getMinSurface(): ?int {
		return $this->minSurface;
	}
	
	/**
	 * @param int $minSurface
	 *
	 * @return PropertySearch
	 */
	public function setMinSurface( int $minSurface ): PropertySearch {
		$this->minSurface = $minSurface;
		
		return $this;
	}
}
