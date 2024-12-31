<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        Log::info('Validated email for checkEmail', ['email' => $validated['email']]);

        $response = Http::post('http://localhost:3000/api/checkEmail', [
            'email' => $validated['email'],
        ]);
        
        Log::info('Response from Node.js API', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->successful()) {
            $rawBody = $response->body();
            Log::info('Raw response body', ['rawBody' => $rawBody]);
        
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

    public function logIn(Request $request)
    {
        Log::info('Login request received', [
            'email' => $request->input('email'),
            'password' => $request->input('password'), 
        ]);
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $response = Http::post('http://localhost:3000/api/verifyPassword', [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        Log::info('Raw response body from Node.js API', [
            'response_body' => $response->body(),
            'response_status' => $response->status(),
        ]);

        if ($response->successful()) {
            $data = json_decode($response->body(), true);
            Log::info('Parsed response data', [
                'data' => $data,
            ]);

            if (!empty($data['passwordCorrect']) && $data['passwordCorrect']) {
                session(['idPekerja' => $data['user']['idPekerja']]);
                return response()->json([
                    'success' => true,
                    'password' =>true,
                    'redirect' => route('workersunion.homePage'), // Add redirect URL
                ]);
            }
            
            // Handle invalid credentials
            return response()->json([
                'success' => true,
                'password' => false,
                'message' => 'Invalid email or password.',
            ]);
        }

        Log::error('Failed to verify credentials', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to verify credentials.',
        ], $response->status());
    }
    


    public function homeIndex()
    {
        $response = Http::post('http://localhost:3000/api/getDataPekerja', [
            'idPekerja' => session('idPekerja')
        ]);

        $data = $response->json(); // Decode the response JSON
        $pekerjas = isset($data['data'][0]) ? $data['data'][0] : null;

        Log::info('Extracted User Data:', ['pekerjas' => $pekerjas]);

        return view('home_page.index', ['pekerjas' => $pekerjas]);
    }
    public function profileIndex()
    {
        $response = Http::post('http://localhost:3000/api/getDataPekerja', [
            'idPekerja' => session('idPekerja')
        ]);

        $data = $response->json(); // Decode the response JSON
        $pekerjas = isset($data['data'][0]) ? $data['data'][0] : null;

        Log::info('Extracted User Data:', ['pekerjas' => $pekerjas]);

        return view('lihat_profil.index', ['pekerjas' => $pekerjas]);
    }
    public function addRingkasan(Request $request)
    {
        $validated = $request->validate([
            'ringkasan' => 'required|string',
        ]);
        $response = Http::post('http://localhost:3000/api/addRingkasan', [
            'idPekerja' => session('idPekerja'),
            'ringkasan' => $validated['ringkasan']
        ]);
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Ringkasan added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to add ringkasan.',
            ], 400);
        }
    }
    public function addInformasiPekerjaan(Request $request)
    {
        $validated = $request->validate([
            'posisiPekerjaan' => 'required|string',
            'namaPerusahaan' => 'required|string',
            'tahunMulaiPekerjaan' => 'required|integer',
            'tahunBerakhirPekerjaan' => 'required|integer',
            'statusJabatanPekerjaan' => 'required|string',
            'deskripsiPekerjaan' => 'required|string'
        ]);
        $response = Http::post('http://localhost:3000/api/addInformasiPekerjaan', [
            'idPekerja' => session('idPekerja'),
            'posisiPekerjaan' => $validated['posisiPekerjaan'],
            'namaPerusahaan' => $validated['namaPerusahaan'],
            'tahunMulaiPekerjaan' => $validated['tahunMulaiPekerjaan'],
            'tahunBerakhirPekerjaan' => $validated['tahunBerakhirPekerjaan'],
            'statusJabatanPekerjaan' => $validated['statusJabatanPekerjaan'],
            'deskripsiPekerjaan' => $validated['deskripsiPekerjaan'],
        ]);
        Log::info('Incoming request data', $request->all());
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Informasi pekerjaan added successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to add informasi pekerjaan.',
            ], 400);
        }
    }
    public function addInformasiPendidikan(Request $request)
    {
        $validated = $request->validate([
            'kursusPendidikan' => 'required|string',
            'lembagaPendidikan' => 'required|string',
            'statusKualifikasiPendidikan' => 'required|string',
            'tahunSelesaiPendidikan' => 'required|integer',
            'poinPentingPendidikan' => 'nullable|string',
        ]);

        Log::info('Incoming request data', $validated);

        $response = Http::post('http://localhost:3000/api/addInformasiPendidikan', array_merge($validated, [
            'idPekerja' => session('idPekerja'),
        ]));

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Informasi pendidikan added successfully!',
            ]);
        } else {
            Log::error('Failed to add informasi pendidikan', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to add informasi pendidikan.',
            ], 400);
        }
    }
    public function addInformasiLisensi(Request $request)
    {
        $validated = $request->validate([
            'namaLisensi' => 'required|string',
            'organisasiPenerbitLisensi' => 'nullable|string',
            'tanggalTerbitLisensi' => 'required|string',
            'tanggalKadaluwarsaLisensi' => 'required|string',
            'statusLisensi'=>'required|string',
            'deskripsiLisensi' => 'nullable|string',
        ]);

        Log::info('Incoming request data', $validated);

        $response = Http::post('http://localhost:3000/api/addInformasiLisensi', array_merge($validated, [
            'idPekerja' => session('idPekerja'),
        ]));

        if ($response->successful()) {
            
            return response()->json([
                'success' => true,
                'message' => 'Informasi pendidikan added successfully!',
            ]);
        } else {
            Log::error('Failed to add informasi pendidikan', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to add informasi pendidikan.',
            ], 400);
        }
    }

    public function addSkills(Request $request)
    {
        $validated = $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'string', 
        ]);

        $response = Http::post('http://localhost:3000/api/addSkills', [
            'idPekerja' => session('idPekerja'),
            'skills' => $validated['skills'],
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Skills saved successfully!',
            ]);
        } else {
            Log::error('Failed to save skills', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to save skills.',
            ], 400);
        }
    }

    public function getSkills(Request $request)
    {
        $idPekerja = session('idPekerja') ?? $request->input('idPekerja');

        if (!$idPekerja) {
            return response()->json([
                'success' => false,
                'message' => 'idPekerja is required.',
            ], 400);
        }

        try {
            $response = Http::post("http://localhost:3000/api/getSkills", [
                'idPekerja' => $idPekerja,
            ]);
            Log::info('Incoming request datssdsa', $response->json()['skills'] ?? []);
            if ($response->successful()) {
                $skills = $response->json()['skills'] ?? [];

                return response()->json([
                    'success' => true,
                    'skills' => $skills,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch skills from API.',
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching skills.',
            ], 500);
        }
    }

    public function deleteSkills(Request $request)
    {
        $idPekerja = session('idPekerja') ?? $request->input('idPekerja');

        if (!$idPekerja) {
            return response()->json([
                'success' => false,
                'message' => 'idPekerja is required.',
            ], 400);
        }

        try {
            $response = Http::post("http://localhost:3000/api/deleteSkills", [
                'idPekerja' => $idPekerja,
            ]);
            if ($response->successful()) {
                $skills = $response->json()['skills'] ?? [];

                return response()->json([
                    'success' => true,
                    'skills' => $skills,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch skills from API.',
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching skills.',
            ], 500);
        }
    }
}
