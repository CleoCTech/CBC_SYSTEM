<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Log;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();
        return view('pages.support_team.sms.index', ['messages' => $messages ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        return view('pages.support_team.sms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            // 'receiver' => 'required|regex:/^\+?2547[0-9]{8}$/',
            'receiver' => 'required',
            'message' => 'required|string|max:160' // Assuming SMS max length is 160 characters
        ];

        // Custom error messages
        $messages = [
            'receiver.required' => 'The receiver phone number is required.',
            //'receiver.regex' => 'The receiver phone number must be a valid Kenyan phone number.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a string.',
            'message.max' => 'The message may not be greater than 160 characters.'
        ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages); 
        $validatedData['status'] = 'sent';
        try {
            //code...
            DB::beginTransaction();
              
            $save = Message::create($validatedData);
             // Send SMS after saving in the database
            // $response = Http::post('https://sms.schoolfixanalytics.com/api/v1/send-sms', [
            //     'message' => $validatedData['message'],
            //     'mobile' => $validatedData['receiver']
            // ]);
            $response = Http::withoutVerifying()->post('https://sms.schoolfixanalytics.com/api/v1/send-sms', [
                'message' => $validatedData['message'],
                'mobile' => $validatedData['receiver']
            ]);
            if ($response->json()['status'] === 'success') {
                $updateData = [
                    'response_status' => 'success',
                    'response_message' => $response->json()['message']
                ];
            }else {
                $updateData = [
                    'response_status' => 'failed',
                    'response_message' => $response->json()['message'] ?? 'Failed to send SMS'
                ];
            }
            // Update the saved message record with response details
            $save->update($updateData);
            DB::commit();
            return redirect('/sms')->with('success', 'Success message received');
        } catch (\Throwable $th) {
            Log::error($th);
            Log::channel('sms_error')->info($th->getMessage());
            DB::rollback();
            return back()->with('error', $th->getMessage());
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
