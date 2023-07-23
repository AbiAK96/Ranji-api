<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ChatItem extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'chat_items';
    
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
     
    protected $fillable = [
        'user_id',
        'receiver_id',
        'message',
        'is_viewed'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'receiver_id' => 'integer', 
        'message' => 'string',
        'is_viewed' => 'boolean'
    ];

    static function saveChat($id,$request)
    {
        $exeChat = ChatItem::where('user_id',$id)->where('receiver_id',auth()->user()->id)->first();
        if ($exeChat == null) {
            $defaultChat = new ChatItem();
            $defaultChat->user_id = $id;
            $defaultChat->receiver_id = auth()->user()->id;
            $defaultChat->message = null;
            $defaultChat->is_viewed = true;
            $defaultChat->save();
        }
        $chat = new ChatItem();
        $chat->user_id = auth()->user()->id;
        $chat->receiver_id = $id;
        $chat->message = $request->message;
        $chat->is_viewed = false;
        $chat->save();
        return $chat;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
