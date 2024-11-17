<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function unApproveItem()
    {
        $items = Item::whereIn('status', ['pending', 'rejected'])->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }
    
    public function approve($item_id)
    {
        $item = Item::whereId($item_id)->whereIn('status', ['pending', 'rejected'])->first();
        if(!$item){
            return response()->json([
                'success' => false,
                'message' => 'Item not found!!',
            ]);
        }
        $item->status = 'approved';
        if($item->save()){
            return response()->json([
                'success' => true,
                'message' => 'Status Updated Successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Status change failed!',
            ]);
        }
        
    }
    public function reject($item_id)
    {
        $item = Item::whereId($item_id)->whereStatus('pending')->first();
        if(!$item){
            return response()->json([
                'success' => false,
                'message' => 'Item not found!!',
            ]);
        }
        $item->status = 'rejected';
        if($item->save()){
            return response()->json([
                'success' => true,
                'message' => 'Status Updated Successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Status change failed!',
            ]);
        }
        
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        
        if(!$item){
            return response()->json([
                'success' => false,
                'message' => 'Item not found!!',
            ]);
        }

        if($item->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Status change failed!',
            ]);
        }
    }
}
