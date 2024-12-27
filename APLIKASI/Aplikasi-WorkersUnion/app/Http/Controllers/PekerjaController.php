<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PekerjaController extends Controller
{
    private $nodeApiBaseUrl = 'http://localhost:3000/api';
    public function daftarIndex()
    {
        $response = Http::get($this->nodeApiBaseUrl);
        return view('daftar.index', ['pekerjas' => $response->json()]);
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'namaDepan' => 'required|string',
        'namaBelakang' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);
    
    $response = Http::post('http://localhost:3000/api', [
        'username' => $validated['namaDepan'] . ' ' . $validated['namaBelakang'],
        'email' => $validated['email'],
        'password' => $validated['password'],
    ]);

    if ($response->successful()) {
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pekerja created successfully!',
            ]);
        }
        return redirect()->route('workersunion.loginIndex')->with('success', 'Pekerja created successfully!');
    } else {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to create pekerja.',
            ], 400);
        }

        return back()->withErrors('Unable to create pekerja.');
    }
}

    public function checkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        \Log::info('Validated email for checkEmail', ['email' => $validated['email']]);

        $response = Http::post('http://localhost:3000/api/checkEmail', [
            'email' => $validated['email'],
        ]);
        
        \Log::info('Response from Node.js API', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->successful()) {
            $rawBody = $response->body();
            \Log::info('Raw response body', ['rawBody' => $rawBody]);
        
            $data = json_decode($rawBody, true); 
        
            if (empty($data['data'])) { 
                return response()->json(['exists' => false, 'message' => 'Email is available.'], 200);
            }
            return response()->json(['exists' => true, 'message' => 'Email already exists.'], 200);
        }
        

        return response()->json(['success' => false, 'message' => 'Failed to check email.'], 500);
    }

    public function loginIndex()
    {
        $response = Http::get($this->nodeApiBaseUrl);
        return view('login.index', ['pekerjas' => $response->json()]);
    }
}
