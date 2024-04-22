<?php

namespace App\Http\Controllers;

use App\Models\TeamData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Scorer;
use App\Models\Chennai;
use App\Models\Mumbai;
use App\Models\Log;
use App\Models\viewer;

class cricket_controller extends Controller{
  public function ScorerRegister(Request $request){

        if(Scorer::count()>0){//checking whether scorer already exists 
            return response()->json(["status"=>"Scorer already exist! "],400);
        }
           $validator= validator::make($request->all(),[
                'name'=>'regex:/^[A-Za-z\s.\'-]+$/|required|string|max:255',
                'email'=>'required|email|string|unique:scorers,email',
                'password' => 'required|min:8'
            ],
            [
                'name.required'=>'the name of scorer is required',
                'email.required'=>'email required or should be of type email only...',
                'password.required' => 'enter password or invalid password',
                'password.min'=>'password should be eight characters alleast'
            ]);
    
            if($validator->fails()){
                return response()->json(["status"=>$validator->errors()],400);
            }
    
           $result= Scorer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password'=> Hash::make($request->password)
            ]);
            if(isset($result)){
                return response()->json(["status"=>"Scorer Registration is Done..."],200);
            }
    
            return response()->json(["status"=>"Scorer Regisration failed."],400);

        }
    
        public function scorerLogin(Request $request) {
            //dd("iam reahing here");
            $validator = Validator::make($request->all(), [  //validating the scorer
                'name' => 'required|regex:/^[A-Za-z\s.\'-]+$/|max:255',
                'password' => 'required|min:8',
            ],
            [
                'name.required' => 'please enter a  name',
                'password.required' => 'enter password or invalid password or should be eight character length',
            ]);
            
            if($validator->fails()){
                return response()->json(["status"=>$validator->errors()],400);
            }
    
            $scorer= Scorer::where('name', $request['name'])->first();//finding the scorer
            //dd($buyer);
            if ($scorer && Hash::check($request['password'], $scorer->password)) {
        
            $token= $scorer->createToken($scorer->name)->plainTextToken;//crating token for scorer 
        
            return response()->json(['message' => 'scorer login successfull','token'=>$token], 200);
        }

        return response()->json(['status'=>"invalid email and password"],404);
        }   
        public function scorerLogout() {
            $user = auth('sanctum')->user();
        
            if ($user) {
                $user->tokens()->delete();
                return response()->json([
                    'message' => 'Logout successful',
                    'status' => 'success'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User not authenticated',
                    'status' => 'error'
                ], 401);
            }
        }
              
        public function viewerRegister(Request $request){

            if(viewer::count()>0){//checking whether scorer already exists 
                return response()->json(["status"=>"viewer already exist! "],400);
            }
               $validator= validator::make($request->all(),[
                    'name'=>'regex:/^[A-Za-z\s.\'-]+$/|required|string|max:255',
                    'email'=>'required|email|string|unique:scorers,email',
                    'password' => 'required|min:8'
                ],
                [
                    'name.required'=>'the name of viewer is required',
                    'email.required'=>'email required or should be of type email only...',
                    'password.required' => 'enter password or invalid password',
                    'password.min'=>'password should be eight characters alleast'
                ]);
        
                if($validator->fails()){
                    return response()->json(["status"=>$validator->errors()],400);
                }
        
               $result= viewer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password'=> Hash::make($request->password)
                ]);
                if(isset($result)){
                    return response()->json(["status"=>"viewer Registration is Done..."],200);
                }
        
                return response()->json(["status"=>"viewer Regisration failed."],400);
    
            }
        
            public function viewerLogin(Request $request) {
                //dd("iam reahing here");
                $validator = Validator::make($request->all(), [  //validating the scorer
                    'name' => 'required|regex:/^[A-Za-z\s.\'-]+$/|max:255',
                    'password' => 'required|min:8',
                ],
                [
                    'name.required' => 'please enter a  name',
                    'password.required' => 'enter password or invalid password or should be eight character length',
                ]);
                
                if($validator->fails()){
                    return response()->json(["status"=>$validator->errors()],400);
                }
        
                $viewer= viewer::where('name', $request['name'])->first();//finding the viewer
                //dd($viewer);
                if ($viewer && Hash::check($request['password'], $viewer->password)) {
            
                $token= $viewer->createToken($viewer->name)->plainTextToken;//crating token for viewer
            
                return response()->json(['message' => 'viewer login successfull','token'=>$token], 200);
            }
    
            return response()->json(['status'=>"invalid email and password"],404);
            }   
            public function viewerLogout() {
                $user = auth('sanctum')->user();
            
                if ($user) {
                    $user->tokens()->delete();
                    return response()->json([
                        'message' => 'Logout successful',
                        'status' => 'success'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'User not authenticated',
                        'status' => 'error'
                    ], 401);
                }
            }
                  

    public function storeData(Request $request)
       {
          // Validate the input
          $request->validate([
            'team_name' => 'required|string',
            'action' => 'required|in:bat,bowl',
        ]);

        $teamBatting = $request->team_name;
        //checking whether team batting is mumbai or chennai
        $teamBowling = ($teamBatting == 'Mumbai') ? 'Chennai' : 'Mumbai';

        // Store the data in the database
        TeamData::create([
            'team_name' => $teamBatting,
            'action' => $request->action,
        ]);

        TeamData::create([
            'team_name' => $teamBowling,
            'action' => ($request->action == 'bat') ? 'bowl' : 'bat',
        ]);

        return response()->json(['message' => 'Data stored successfully']);
    }

public function select_batsmen()
{
    // Retrieve the team that is currently batting
    $battingTeam = TeamData::where('action', 'bat')->first();
     //dd($battingTeam);
    if (TeamData::where('action', 'bat')->first()) {
       // dd($battingTeam->team_name);
        // Check the team name and select the first batsman accordingly
        if (TeamData::where('action', 'bat')->first()->team_name =="Chennai") {
           // dd("lsdkjf;sdf");
            // Retrieve the players for Chennai and select the first batsman
            $players = Chennai::first();
            return $players->playername;
        } elseif ($battingTeam->team_name== 'Mumbai') {
            // Retrieve the players for Mumbai and select the first batsman
            $players = Mumbai::first();
            if ($players) {
                return $players->playername;
            }
        }
    }
    
    return "No batsman found"; // Return a default message if no batsman is found
}
   public function select_bowler()
{
    $bowlingTeam = TeamData::where('action', 'bowl')->first();

    if ($bowlingTeam) {
        if ($bowlingTeam->team_name == "Chennai") {
            // Return the name of the first bowler for Chennai
            $bowler = Chennai::first();
           return  $bowler->playername;
        } elseif ($bowlingTeam->team_name == "Mumbai") {
            // Return the name of the first bowler for Mumbai
            $bowler = Mumbai::first();
            return $bowler->playername;
        } else {
            return response()->json(['message' => 'Invalid team name'], 404);
        }
    }
}

public function add_score(Request $request)
{
    // Get the latest log entry
    $latestLog = Log::latest()->first();

    // Get the current over
    $current_over = $latestLog ? $latestLog->current_over : 1;

    // Validate the request data
    $validator = Validator::make($request->all(), [
        'ball' => 'required|in:0,1,2,3,4,5,6,noball,wide,wicket',
        'batsman_run' => 'required|in:0,1,2,3,4,6,out'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => $validator->errors()->first()
        ], 422);
    }

    // Calculate the runs based on the ball type
    switch ($request->ball) {
        case 1:
        case 2:
        case 3:
        case 4:
        case 6:
            $run = $request->ball;
            break;
        case 'noball':
            $run = 1 + $request->batsman_run;
            break;
        case 'wide':
            $run = 1;
            break;
        default:
            $run = 0;
            break;
    }

    // Check if a wicket is taken
    $isWicket = $request->ball == 'wicket';

    // Increment the ball count unless it's a wide or no-ball
    $latestCount = $latestLog ? ($request->ball != 'noball' && $request->ball != 'wide' ? $latestLog->count + 1 : $latestLog->count) : 0;

    // Creating a new log entry
    Log::create([
        'batsman' => $this->select_batsmen(),
        'isout' => $isWicket,
        'hisruns' => $isWicket ? 0 : $request->input('batsman_run'),
        'bowler' => $this->select_bowler(),
        'onthisbowl' => $request->input('ball'),
        'current_runs' => $run + ($latestLog ? $latestLog->current_runs : 0),
        'current_wickets' => $isWicket ? ($latestLog ? $latestLog->current_wickets + 1 : 1) : ($latestLog ? $latestLog->current_wickets : 0),
        'current_over' => $latestCount == 6 ? $current_over + 1 : $current_over,
        'count' => $latestCount == 6 ? 0 : $latestCount
    ]);

    return response()->json([
        'message' => 'Runs added successfully.'
    ], 200);
}

public function scoreCard(){ //showing the scorecard
    return response(["Batmen name"=>Log::first()->batsman,
                     "Batemen Score"=>Log::sum('hisruns'),
                     "Bowler Name"=>Log::first()->bowler,
                      "Bowler Score"=>Log::max('current_runs'),
                      "current over"=>Log::max('current_over'),
                      "balls completed"=>Log::where('id',Log::max('id'))->first()->count],200);
}
}