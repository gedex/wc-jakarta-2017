<?php
namespace Gedex\WCJKT\Restaurant\Data_Stores;

use Gedex\WCJKT\Restaurant\Data_Objects\Restaurant;

interface Restaurant_Interface {
	public function create( Restaurant &$restaurant );
	public function read( Restaurant &$restaurant );
	public function update( Restaurant &$restaurant );
	public function delete( Restaurant &$restaurant );
}
