<?php
/**
 * Created by PhpStorm.
 * User: Buwaneka Boralessa
 * Date: 8/30/2016
 * Time: 10:28 PM
 */

namespace App\Http\Controllers;


use App\Notifications;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User: Buwaneka Boralessa
 *
 * Class NotificationsController
 * @package App\Http\Controllers
 */
class NotificationsController extends Controller
{
    /* Constants */
    // default user id
    var $DEFAULT_USER_ID = 0;

    // view status
    var $VIEW_PENDING = 'Pending';
    var $VIEW_READ = 'Read';

    // types
    var $USER_PROFILE = "user_profile";
    var $USER_UPDATE = "user_update";
    var $GENERAL = "general";
    var $ACCOUNT_SETTINGS = "account_settings";

    /**
     * Get notifications for user ID or in general publications as well
     *
     * @param Request $request
     * @return mixed
     */
    public function browseNotification(Request $request)
    {
        $notificationsStack = array();
        if (isset($request->user_id)) {
            // browse all general notifications
            foreach (Notifications::where('user_id', $this->DEFAULT_USER_ID)->cursor() as $notification) {
                $temp['id'] = $notification->id;
                $temp['user_id'] = $notification->user_id;
                $temp['type'] = $notification->type;
                $temp['url'] = $notification->url;
                $temp['header_text'] = $notification->header_text;
                $temp['detail_text'] = $notification->detail_text;

                array_push($notificationsStack, $temp);
            }

            // browse user specific notifications
            foreach (Notifications::where('user_id', $request->user_id)->where('view_status', $this->VIEW_PENDING)->cursor() as $notification) {
                $temp['id'] = $notification->id;
                $temp['user_id'] = $notification->user_id;
                $temp['type'] = $notification->type;
                $temp['url'] = $notification->url;
                $temp['header_text'] = $notification->header_text;
                $temp['detail_text'] = $notification->detail_text;

                array_push($notificationsStack, $temp);
            }

            return response()->json($notificationsStack);
        } else {
            // browse all general notifications
            foreach (Notifications::where('user_id', $this->DEFAULT_USER_ID)->cursor() as $notification) {
                $temp['id'] = $notification->id;
                $temp['user_id'] = $notification->user_id;
                $temp['type'] = $notification->type;
                $temp['url'] = $notification->url;
                $temp['header_text'] = $notification->header_text;
                $temp['detail_text'] = $notification->detail_text;

                array_push($notificationsStack, $temp);
            }

            return response()->json($notificationsStack);
        }
    }

    /**
     * Insert new notification entry
     * data given by end user through API call
     *
     * @param Request $request
     * @return int
     */
    public function insertNotification(Request $request)
    {
        if (isset($request->type) && isset($request->url) && isset($request->header_text) && isset($request->detail_text)) {
            $user_id = $this->DEFAULT_USER_ID; // default user id for post by system admin
            // check for user id present
            if (isset($request->user_id) && $request->user_id != '') {
                $user_id = $request->user_id;
            }

            $notification = new Notifications();
            $notification->user_id = $user_id;
            $notification->type = $request->type;
            $notification->url = $request->url;
            $notification->header_text = $request->header_text;
            $notification->detail_text = $request->detail_text;
            $notification->view_status = $this->VIEW_PENDING; // set default view status as pending
            $notification->timestamps = new \DateTime();

            $notification->save();

            return Response::HTTP_CREATED;
        } else {
            return Response::HTTP_NOT_ACCEPTABLE;
        }
    }

    /**
     * Mark notifications as read for their notification ID
     * this process happens, when user click on some notification
     *
     * @param Request $request
     * @return int
     */
    public function markAsReadNotification(Request $request){
        if(isset($request->notification_id) && $request->notification_id != ""){
            $notification = Notifications::find($request->notification_id);
            if(isset($notification) && $notification != null){
                $notification->view_status = $this->VIEW_READ;
                $notification->save();

                return Response::HTTP_OK;
            } else {
                return Response::HTTP_NOT_FOUND;
            }
        } else {
            return Response::HTTP_NOT_ACCEPTABLE;
        }
    }
}