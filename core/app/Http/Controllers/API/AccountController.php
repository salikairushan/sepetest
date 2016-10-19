<?php
/**
 * Created by PhpStorm.
 * User: alexv
 * Date: 9/18/2016
 * Time: 10:37 PM
 */

namespace App\Http\Controllers\API;
use App\Http\Helpers\UserSession;
use App\Http\ModelWrappers\V1\ResponseWrapper;
use App\Http\ModelWrappers\V1\usersWrapper;
use App\Http\Strings\Request\Words;
use App\Http\Utils\Encryptions;
use App\Http\Utils\StringOperations;
use App\User;
use App\UserManagementCrone;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;

class AccountsController extends Controller
{
    /**
     * AccountsController constructor.
     */
    function __construct()
    {
        $this->middleware('AdminCheck');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     *
     * This will send the users and filter them accordingly
     *
     */
    public function getUers(Request $request){

        $response = new ResponseWrapper();
        $responseData = new AccountRequestSend();
        try{

            $page = $request->get(Words::$page,1);

            $page--;
            $rowsPerPage = $request->get(Words::$rowsPerPage,10);
            $filter = $request->get(Words::$pageFilter,1);
            $searchText = $request->get(Words::$searchText,"");
            $skip = $rowsPerPage * $page;
            $users = null;
            $dataCount = 0;
            $searchText = trim($searchText);
            if($searchText == ""){
                if($filter == 1){
                    $users = User::select('id', 'fname','lname','email','gender','priority','role','verified','active')->skip($skip)->take($rowsPerPage)->get();
                    $dataCount = User::count();
                }else if($filter == 2){
                    $users = User::select('id', 'fname','lname','email','gender','priority','role','verified','active')->where('active', '=', true)->skip($skip)->take($rowsPerPage)->get();
                    $dataCount = User::where('active', '=', true)->count();
                }else{
                    $users = User::select('id', 'fname','lname','email','gender','priority','role','verified','active')->where('active', '=', false)->skip($skip)->take($rowsPerPage)->get();
                    $dataCount = User::where('active', '=', false)->count();
                }
            }else{
                if($filter == 1){
                    $users = User::select('id', 'fname','lname','email','gender','priority','role','verified','active')->where(function($query) use($searchText){
                        $query->where('fname', 'like', '%' . $searchText . '%')->orWhere('lname', 'like', '%' . $searchText . '%')->orWhere('email', 'like', '%' . $searchText . '%');
                    })->skip($skip)->take($rowsPerPage)->get();

                    $dataCount = User::where(function($query) use($searchText){
                        $query->where('fname', 'like', '%' . $searchText . '%')->orWhere('lname', 'like', '%' . $searchText . '%')->orWhere('email', 'like', '%' . $searchText . '%');
                    })->count();
                }else if($filter == 2){
                    $users = User::select('id', 'fname','lname','email','gender','priority','role','verified','active')->where(function($query) use($searchText){
                        $query->where('fname', 'like', '%' . $searchText . '%')->orWhere('lname', 'like', '%' . $searchText . '%')->orWhere('email', 'like', '%' . $searchText . '%');
                    })->where('active', '=', true)->skip($skip)->take($rowsPerPage)->get();

                    $dataCount = User::where('active', '=', true)->where(function($query) use($searchText){
                        $query->where('fname', 'like', '%' . $searchText . '%')->orWhere('lname', 'like', '%' . $searchText . '%')->orWhere('email', 'like', '%' . $searchText . '%');
                    })->count();
                }else{
                    $users = User::select('id', 'fname','lname','email','gender','priority','role','verified','active')->where('active', '=', false)->where(function($query) use($searchText){
                        $query->where('fname', 'like', '%' . $searchText . '%')->orWhere('lname', 'like', '%' . $searchText . '%')->orWhere('email', 'like', '%' . $searchText . '%');
                    })->skip($skip)->take($rowsPerPage)->get();
                    $dataCount = User::where('active', '=', false)->where(function($query) use($searchText){
                        $query->where('fname', 'like', '%' . $searchText . '%')->orWhere('lname', 'like', '%' . $searchText . '%')->orWhere('email', 'like', '%' . $searchText . '%');
                    })->count();
                }
            }

            //use response wrapper
            $response->setCode(200);
            $responseData->user = $users;
            $responseData->totalRecords = $dataCount;
            $response->setData($responseData);
            return response()->json($response->getResponse());
        }catch (Exception $ex){
            $response->setCode(500);
            $response->setDescription($ex);
            return response()->json($response->getResponse());
        }

    }

    /**
     * @param Request $request
     * @return mixed
     * This will update the users
     */
    public function updateUser(Request $request)
    {


        $response = new ResponseWrapper();

        try{
            $userFromClient = $request->get(Words::$user,null);
            $userFromClient = json_decode($userFromClient);
            if($userFromClient == null){
                $response->setCode(500);
                $response->setDescription("You haven't send the user object");
                return response()->json($response->getResponse());
            }
            $email = $userFromClient->email;

            if($email == ''){
                $response->setCode(500);
                $response->setDescription("Error");
                return response()->json($response->getResponse());
            }

            // level 4 is admin
            $user = null;
            $userUpdating = null;
            $user = \App\Http\Utils\UserSession::GetUserWithRequest($request);
            $userUpdating = User::where('email','=',$email)->first();
            if($user->role < 4){
                $response->setCode(403);
                $response->setDescription("UnAuthorized");
                return response()->json($response->getResponse());
            }elseif($userUpdating->role > $user->role){
                $response->setCode(403);
                $response->setDescription("You can't edit a user in a higher level than your's");
                return response()->json($response->getResponse());
            }elseif ($user->role < $userFromClient->UserRole->value ){
                $response->setCode(403);
                $response->setDescription("You can't update user to a higher level than your level");
                return response()->json($response->getResponse());
            }
            $userUpdating->fname = $userFromClient->fname;
            $userUpdating->lname = $userFromClient->lastname;
            $userUpdating->gender = $userFromClient->gender;
            $userUpdating->role = $userFromClient->UserRole->value;
            $userUpdating->priority = $userFromClient->priority->value;
            if(($userUpdating->email != $user->email)){

                if($userUpdating->active == false){
                    if($userFromClient->active == true){
                        $cronEmail = new UserManagementCrone();
                        $cronEmail->fname = $userUpdating->fname;
                        $cronEmail->lname = $userUpdating->lname;
                        $cronEmail->email = $userUpdating->email;
                        $cronEmail->subject = "Account is active";
                        $cronEmail->message = "Your account at SLIIT resource management is now active";
                        $cronEmail->save();
                    }
                }

                $userUpdating->active = $userFromClient->active;
            }
            if($userFromClient->isPasswordReset){
                //send this password using a cron(Add this to the cron table)
                $tempPassword = StringOperations::generateRandomString(7);
                $userUpdating->password = Encryptions::getPassword($tempPassword);

                if($userUpdating->active == true){
                    $cronEmail = new UserManagementCrone();
                    $cronEmail->fname = $userUpdating->fname;
                    $cronEmail->lname = $userUpdating->lname;
                    $cronEmail->email = $userUpdating->email;
                    $cronEmail->subject = "Password Reset";
                    $cronEmail->message = "Your Password have been rested, Your new Password is : ".$tempPassword;
                    $cronEmail->save();
                }
            }
            $userUpdating->save();

            $response->setCode(200);
            $response->setDescription("user updated successfully");
        }catch(Exception $ex){
            $response->setCode(500);
            $response->setDescription($ex);
        }
        return response()->json($response->getResponse());
    }

    /**
     * @param Request $request
     * @return mixed
     * This will insert the users
     */
    public function newUser(Request $request)
    {
        $response = new ResponseWrapper();
        try{
            $userFromClient = $request->get(Words::$user,null);
            $userFromClient = json_decode($userFromClient);
            if($userFromClient == null){
                $response->setCode(500);
                $response->setDescription("You haven't send the user object");
                return response()->json($response->getResponse());
            }
            $email = $userFromClient->email;

            if($email == ''){
                $response->setCode(500);
                $response->setDescription("Error");
                return response()->json($response->getResponse());
            }

            $user = null;
            $userCreating = null;
            $userCreating = User::where('email','=',$email)->first();

            if($userCreating != null){
                $response->setCode(500);
                $response->setDescription("User's email is Already Registered");
                return response()->json($response->getResponse());
            }
            $user = \App\Http\Utils\UserSession::GetUserWithRequest($request);
            if($user->role < $userFromClient->role->value){
                $response->setCode(500);
                $response->setDescription("You can't update user to a higher level than your level");
                return response()->json($response->getResponse());
            }
            $tempPassword = StringOperations::generateRandomString(7);
            $userCreating = new User();
            $userCreating->email = $userFromClient->email;
            $userCreating->fname = $userFromClient->fname;
            $userCreating->lname = $userFromClient->lastname;
            $userCreating->gender = $userFromClient->gender;
            $userCreating->role = $userFromClient->role->value;
            $userCreating->priority = $userFromClient->priority->value;
            $userCreating->password = (trim($userFromClient->password) == "")?Encryptions::getPassword($tempPassword):Encryptions::getPassword($userFromClient->password);
            $userCreating->active = $userFromClient->active;
            $userCreating->verified = 1;
            $userCreating->save();


            $cronEmail = new UserManagementCrone();
            $cronEmail->fname = $userCreating->fname;
            $cronEmail->lname = $userCreating->lname;
            $cronEmail->email = $userCreating->email;
            $cronEmail->subject = "Your account is created";
            $cronEmail->message = "Your account is now registered and Your new Password is : ".((trim($userFromClient->password) == "")?$tempPassword:$userFromClient->password);
            $cronEmail->save();


            $response->setCode(200);
            $response->setDescription("user created successfully");
        }catch(Exception $ex){
            $response->setCode(500);
            $response->setDescription($ex);
        }
        return response()->json($response->getResponse());

    }
    
}

/**
 * Class AccountRequestSend
 * @package App\Http\Controllers\API
 * Used in the User Get
 */
class AccountRequestSend{
    /**
     * @var
     */
    public $user;
    /**
     * @var
     */
    public $totalRecords;
}