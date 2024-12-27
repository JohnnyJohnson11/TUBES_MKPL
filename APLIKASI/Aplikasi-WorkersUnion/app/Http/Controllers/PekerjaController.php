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
        $response = Http::post('http://localhost:3000/api/checkemail', [
            'email' => $validated['email'],
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if ($data['exists'] ?? false) {
                return back()->withErrors(['email' => 'Email already exists. Please use a different email.']);
            }
            return redirect()->route('workersunion.pekerjastore')->with('success', 'Email is valid and can be used.');
        } else {
            return back()->withErrors('Unable to create pekerja.');
        }
    }
    public function loginIndex()
    {
        $response = Http::get($this->nodeApiBaseUrl);
        return view('login.index', ['pekerjas' => $response->json()]);
    }
}
