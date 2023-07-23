<?php

namespace App\Http\Controllers\API\V1;

use App\Models\V1\ChatItem;
use App\Models\V1\User;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use DB;

class ChatController extends AppBaseController
{
    public function getChat($id)
    {
      try {
        $update = ChatItem::Where('user_id',$id)->Where('receiver_id',auth()->user()->id)->update(
          array(
            'is_viewed' => true,
            )
          );
        $firstQuery = ChatItem::where('user_id',auth()->user()->id)->where('receiver_id',$id)->where('message','!=',null);
        $secondQuery = ChatItem::Where('user_id',$id)->Where('receiver_id',auth()->user()->id)->where('message','!=',null);

        $chatItems = $firstQuery->union($secondQuery)->OrderBy('created_at', 'asc')->paginate(10);

        if (count($chatItems) != 0) {
          return $this->sendResponse($chatItems, 'Messages retrived successfully' ,null);
        } else {
          return $this->sendResponse(null, null, 'Messages not found');
        }
      } catch (\Exception $e){
          return $this->sendResponse(null, null, 'Messages retrived failed. '. $e->getMessage());
      }
    }

    public function saveChat(Request $request ,$id)
    {
      try {
        $chat = ChatItem::saveChat($id,$request);
      } catch (\Exception $e){
          return $this->sendResponse(null, null, 'Sending failed. '. $e->getMessage());
      }
    }

    public function getAllChat()
    {
      try {
        $totalMessages = ChatItem::where('receiver_id', auth()->user()->id)
                                ->select( DB::raw('COUNT(CASE WHEN is_viewed = 0 THEN message ELSE NULL END) AS message_count'), 'user_id')
                                ->groupBy('user_id')
                                ->orderByRaw('MIN(created_at) DESC')
                                ->get();

        if (count($totalMessages) == 0){
          return $this->sendResponse(null, null, 'No chats available');
        }
        foreach ($totalMessages as $message ) {
          $user = User::where('id',$message->user_id)->first();
          $message->user_name = $user->first_name.' '.$user->last_name;
          $message->user_profile_pic = $user->profile_picture;
        }
        return $this->sendResponse($totalMessages, 'Chats retrived successfully' ,null);
      } catch (\Exception $e){
          return $this->sendResponse(null, null, 'Retrived failed. '. $e->getMessage());
      }
    }
}
