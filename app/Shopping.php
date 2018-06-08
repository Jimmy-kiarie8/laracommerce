<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Shopping 
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldcart)
    {
    	if ($this->items) {
	    	$this->items = $oldcart->items;
	    	$this->totalPrice = $oldcart->totalPrice;
	    	$this->totalQty = $oldcart->totalQty;
	    }
    }

    public function add($item, $id)
    {	
    	$storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
    	if ($this->items) {
    		if (array_key_exists($id, $this->items)) {
    			$storedItem = $this->items[$id];
    		}
    	}
    	$this->items[$id] = $storedItem;
    	$storedItem['qty']++;
    	$storedItem['price'] = $item->price * $storedItem['qty'];
    	$this->totalQty++;
    	$this->totalPrice += $item->price;
    	// return $storedItem;
    }
}
