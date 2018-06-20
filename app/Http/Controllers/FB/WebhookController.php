<?php

namespace App\Http\Controllers\FB;

use App\Services\WitService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function verify(Request $request)
    {
        $verifyToken = config('fb.webhook.verify_token');
        $mode = $request->get('hub_mode');
        $token = $request->get('hub_verify_token');
        $challenge = $request->get('hub_challenge');

        if ($mode && $token) {
            if ($mode == 'subscribe' && $token == $verifyToken) {
                return $challenge;
            }
        }

        return response()->json(['error' => 'Unauthorized', 'code' => 403], 401);

        //return response()->json($request->all());
    }

    public function handle(Request $request, WitService $witService)
    {
        Log::info(json_encode($request->all()));
        $client = new \GuzzleHttp\Client();
        if ($request->get('object') == 'page') {
            foreach ($request->get('entry') as $entry) {
                foreach ($entry['messaging'] as $messaging) {
                    $headers = ['Authorization' => 'Bearer DEW4SK7ZXV342RJPXQONQLOZDEY7KB4S'];
                    $response = $client->request('GET', 'https://api.wit.ai/message?v='.time().'&q='.$messaging['message']['text'], ['headers' => $headers]);
                    $wit = json_decode($response->getBody(), true);
                    $content = $witService->parse($wit);

                    $headers = ['content-type' => 'application/json'];
                    $body = [
                        'recipient' => [ 'id' => $messaging['sender']['id'] ],
                        'message' => [ 'text' => $content ]
                    ];
                    $promise = $client->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token='.config('fb.access_token'), ['headers' => $headers, 'body' => json_encode($body)]);
                    Log::info($promise->getBody());

//                    $promise->then(function($response){
//                        Log::info($response->getBody());
//                    });
                    //$promise->wait();
                }
            }
        }
        //Log::info(json_encode($request->all()));
        return response()->json($request->all());
    }
}
