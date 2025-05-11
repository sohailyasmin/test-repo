<?php

// app/Http/Controllers/ApiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller {
    public function receiveData( Request $request ) {
         
        $request->validate( [
            'name' => 'required|string',
            'email' => 'required|string',
        ] );
         if ( !$request->hasHeader( 'My-Token' ) || !$request->hasHeader( 'My-key' ) ) {
            return response()->json( [ 'error' => 'Missing headers' ], 400 );
        }

        // Get body parameters
        $param1 = $request->input( 'name' );
        $param2 = $request->input( 'email' );

        // Get header parameters
        $header1 = $request->header( 'My-Token' );
        $header2 = $request->header( 'My-Key' );
        $resource = $request->header( 'Resource' );
         
        $clientId = $header1;
        $clientSecret = $header2;
        
        $clientId = $header1;
        $clientSecret = $header2;

       // dd($clientId,$clientSecret );
        $tokenUrl = config( 'services.wso2.WSO2_TOKEN_URL' );
        
        $wso2BaseUrl = config('services.wso2.WSO2_API_BASE_URL');
//dd($tokenUrl);
        $response = Http::asForm()

                        ->withBasicAuth( $clientId, $clientSecret )
                        ->withOptions( [ 'verify' => false ] ) // Disable SSL verification for localhost
                        ->post( $tokenUrl, [
                            'grant_type' => 'client_credentials',
                        ] );
         // dd($tokenUrl, $response);                  
        $accessToken = $response[ 'access_token' ];
        $apiUrl =  $wso2BaseUrl. '/'.$resource;
       //                  dd($apiUrl);
        $apiResponse = Http::withToken($accessToken)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'My-Key' => $clientId,
                'My-Token' => $clientSecret,
                // any custom headers
            ])
            ->post($apiUrl, [
                'name' => $param1,
                'email' => $param2,
                // POST body parameters
            ] );
        
        $data = $apiResponse->json();
        
        return response()->json( [
            'param1' => $param1,
            'param2' => $param2,
            'header1' => $header1,
            'header2' => $header2,
            'data'  =>  $data
        ] );
    }
}
