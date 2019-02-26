<?php

namespace App\Http\Controllers;


use App\Item;
use Illuminate\Http\Request;

class ListController extends Controller
{

	 public function index()
    {
    	$item = Item::all();
    	return view('list')->withItems($item);
    }
    public function create(Request $request)
    {
    	$item = new Item();
    	$item->item = $request->text;
    	$item->save();
    	return 'done';
    }

      public function delete(Request $request)
    {
    	Item::where('id',$request->id)->delete();
    	return 'done';
    }


      public function update(Request $request)
    {
    	$item = Item::find($request->id);
    	$item->item = $request->text;
    	
    	$item->save();
    	
    }

    public function search(Request $request)
    {

        $term= $request->term;
        $items = Item::where('item','LIKE','%'.$term.'%')->get();
        if(count($items)==0)
        {
            $searchResult[] = 'no item found';
        }
        else{
            foreach ($items as $key => $value) {
                $searchResult[]=$value->item;
         }
  
    }
    }
}
