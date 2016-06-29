<?php

/**
 * Not really a class, jump simple 'struct' storing multiple choice option item.
 */
class VP_Control_Field_Item_Generic
{

	public $img;

	public $value;

	public $label;
	
	public $revslider;
	
	public $store;

	public function __construct(){}

	public function img($img)
	{
		$this->img = $img;
		return $this;
	}

	public function value($value)
	{
		$this->value = $value;
		return $this;
	}

	public function label($label)
	{
		$this->label = $label;
		return $this;
	}
	
	public function revslider($revslider)
	{
		$this->revslider = $revslider;
		return $this;
	}
	
	public function store($store)
	{
		$this->store = $store;
		return $this;
	}

}

/**
 * EOF
 */