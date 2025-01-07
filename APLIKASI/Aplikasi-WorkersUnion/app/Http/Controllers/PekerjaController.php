<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PekerjaController extends Controller
{
    private $nodeApiBaseUrl = 'http://localhost:3000/api';
    public function halamanUtamaIndex()
    {
        session()->forget('idPekerja');
        session()->forget('idPerusahaan');
        return view('halaman_utama.index');
    }
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

        $response = Http::post('http://localhost:3000/api/', [
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

    public function getDataPekerja(Request $request){
        $validated = $request->validate([
            'idPekerja' => 'required|integer',
        ]);
        $response = Http::post('http://localhost:3000/api/getDataPekerja', [
            'idPekerja' => $validated['idPekerja']
        ]);
        if ($response->successful()) {
            $data = $response->json()['data'][0] ?? [];
            return response()->json([
                'success' => true,
                'message' => 'Ringkasan added successfully!',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to add ringkasan.',
            ], 400);
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
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $response = Http::post('http://localhost:3000/api/verifyPassword', [
            'email' => $validated['email'],
            'password' => $validated['password'],
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

    public function addBahasa(Request $request)
    {
        $validated = $request->validate([
            'bahasa' => 'required|string',
        ]);

        Log::info('Incoming request data', $validated);

        $response = Http::post('http://localhost:3000/api/addBahasa', array_merge($validated, [
            'idPekerja' => session('idPekerja'),
        ]));

        if ($response->successful()) {
            
            return response()->json([
                'success' => true,
                'message' => 'Informasi pendidikan added successfully!',
            ]);
        } else {
            Log::error('Failed to add informasi bahasa', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to add informasi bahasa.',
            ], 400);
        }
    }

    public function uploadResume(Request $request)
    {
        $validated = $request->validate([
            'resume' => 'required|string',
            'namaResume' => 'required|string',
        ]);

        $response = Http::post('http://localhost:3000/api/uploadResume', [
            'idPekerja' => session('idPekerja'), 
            'resume' => $validated['resume'],
            'namaResume' => $validated['namaResume'],
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully via Node.js!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to upload file via Node.js.',
            ], 400);
        }
    }
    public function halamanUtamaPerusahaanIndex()
    {
        return view('halaman_utama_perusahaan.index');
    }
    public function lihatPekerjaan()
    {
        try {
            // Fetch perusahaan and pekerjaan data
            $perusahaanResponse = Http::get("http://localhost:3000/api/getPerusahaanAndPekerjaan");
            $pekerjaandisplay = [];
            if ($perusahaanResponse->successful()) {
                $pekerjaandisplay = $perusahaanResponse->json()['pekerjaans'] ?? [];
            } else {
                Log::error('Failed to fetch perusahaan and pekerjaan data from API.', [
                    'status' => $perusahaanResponse->status(),
                    'response' => $perusahaanResponse->body(),
                ]);
            }
    
            // Fetch pekerja data
            $pekerjaResponse = Http::post('http://localhost:3000/api/getDataPekerja', [
                'idPekerja' => session('idPekerja')
            ]);
            $pekerjas = null;
            if ($pekerjaResponse->successful()) {
                $data = $pekerjaResponse->json();
                $pekerjas = $data['data'][0] ?? null;
            } else {
                Log::error('Failed to fetch pekerja data from API.', [
                    'status' => $pekerjaResponse->status(),
                    'response' => $pekerjaResponse->body(),
                ]);
            }
    
            // Return the view with combined data
            return view('lihatPekerjaan.index', [
                'pekerjaandisplay' => $pekerjaandisplay,
                'pekerjas' => $pekerjas,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error fetching combined data: " . $e->getMessage());
    
            return redirect()->back()->withErrors('An error occurred while fetching combined data.');
        }
    }
    public function lamarPekerjaanStorePage1(Request $request){
        $validated = $request->validate([
            'answersString' => 'required|string',
        ]);
    
        session()->put('lamarPekerjaanPage1', $validated);
    
        if (session()->has('lamarPekerjaanPage1')) {
            Log::info('Session data for Page 1 stored:', session('lamarPekerjaanPage1'));
            return response()->json([
                'success' => true,
                'message' => 'Data successfully stored in session.',
                'redirect' => route('workersunion.lamarPekerjaanPage2'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store data in session.',
            ], 500);
        }
    }
    public function lamarPekerjaanPage2()
    {
        try {
            // Fetch perusahaan and pekerjaan data
            $pekerjaanResponse = Http::post('http://localhost:3000/api/getPekerjaanAndPerusahaanById', [
                'idPekerjaan' => session('idPekerjaan')
            ]);
            $pekerjaan = [];
            if ($pekerjaanResponse->successful()) {
                $data = $pekerjaanResponse->json();
                $pekerjaan = $data['pekerjaans'][0] ?? null;
            } else {
                Log::error('Failed to fetch perusahaan and pekerjaan data from API.', [
                    'status' => $pekerjaanResponse->status(),
                    'response' => $pekerjaanResponse->body(),
                ]);
            }
    
            // Fetch pekerja data
            $pekerjaResponse = Http::post('http://localhost:3000/api/getDataPekerja', [
                'idPekerja' => session('idPekerja')
            ]);
            $pekerjas = null;
            if ($pekerjaResponse->successful()) {
                $data = $pekerjaResponse->json();
                $pekerjas = $data['data'][0] ?? null;
            } else {
                Log::error('Failed to fetch pekerja data from API.', [
                    'status' => $pekerjaResponse->status(),
                    'response' => $pekerjaResponse->body(),
                ]);
            }
            return view('halamanResume.index2', [
                'pekerjaan' => $pekerjaan,
                'pekerjas' => $pekerjas,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error fetching combined data: " . $e->getMessage());
    
            return redirect()->back()->withErrors('An error occurred while fetching combined data.');
        }
    }

    public function lamarPekerjaanPage3()
    {
        try {
            // Fetch perusahaan and pekerjaan data
            $pekerjaanResponse = Http::post('http://localhost:3000/api/getPekerjaanAndPerusahaanById', [
                'idPekerjaan' => session('idPekerjaan')
            ]);
            $pekerjaan = [];
            if ($pekerjaanResponse->successful()) {
                $data = $pekerjaanResponse->json();
                $pekerjaan = $data['pekerjaans'][0] ?? null;
            } else {
                Log::error('Failed to fetch perusahaan and pekerjaan data from API.', [
                    'status' => $pekerjaanResponse->status(),
                    'response' => $pekerjaanResponse->body(),
                ]);
            }
    
            // Fetch pekerja data
            $pekerjaResponse = Http::post('http://localhost:3000/api/getDataPekerja', [
                'idPekerja' => session('idPekerja')
            ]);
            $pekerjas = null;
            if ($pekerjaResponse->successful()) {
                $data = $pekerjaResponse->json();
                $pekerjas = $data['data'][0] ?? null;
            } else {
                Log::error('Failed to fetch pekerja data from API.', [
                    'status' => $pekerjaResponse->status(),
                    'response' => $pekerjaResponse->body(),
                ]);
            }
            return view('halamanResume.index3', [
                'pekerjaan' => $pekerjaan,
                'pekerjas' => $pekerjas,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error fetching combined data: " . $e->getMessage());
    
            return redirect()->back()->withErrors('An error occurred while fetching combined data.');
        }
    }

    public function updatePekerja(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'lokasi' => 'required|string',
            'nomorHP' => 'required|string',
            'email' => 'required|email',
        ]);
        $response = Http::post('http://localhost:3000/api/updatePekerja', [
            'idPekerja' => session('idPekerja'),
            'username' => $validated['username'],
            'lokasi' => $validated['lokasi'],
            'nomorHP' => $validated['nomorHP'],
            'email' => $validated['email'],
        ]);

        if ($response->successful()) {
            $data = json_decode($response->body(), true);
            Log::info('Parsed response data', [
                'data' => $data,
            ]);

            if ($data['dontExist']) {
                return response()->json([
                    'success' => true,
                    'dontExist' =>true,
                ]);
            }
            return response()->json([
                'success' => true,
                'dontExist' => false,
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
    public function createLamaran(Request $request)
    {
        $response = Http::post('http://localhost:3000/api/createLamaran', [
            'idPekerja' => session('idPekerja'),
            'idPekerjaan' => session('idPekerjaan'),
            'jawaban' => session('lamarPekerjaanPage1')['answersString'],
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'dontExist' => false,
                'redirect' => route('workersunion.lamarPekerjaanPage4'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to verify credentials.',
        ], $response->status());
    }
    public function lamarPekerjaanPage4()
    {
        try {
            // Fetch perusahaan and pekerjaan data
            $pekerjaanResponse = Http::post('http://localhost:3000/api/getPekerjaanAndPerusahaanById', [
                'idPekerjaan' => session('idPekerjaan')
            ]);
            $pekerjaan = [];
            if ($pekerjaanResponse->successful()) {
                $data = $pekerjaanResponse->json();
                $pekerjaan = $data['pekerjaans'][0] ?? null;
            } else {
                Log::error('Failed to fetch perusahaan and pekerjaan data from API.', [
                    'status' => $pekerjaanResponse->status(),
                    'response' => $pekerjaanResponse->body(),
                ]);
            }
    
            // Fetch pekerja data
            $pekerjaResponse = Http::post('http://localhost:3000/api/getDataPekerja', [
                'idPekerja' => session('idPekerja')
            ]);
            $pekerjas = null;
            if ($pekerjaResponse->successful()) {
                $data = $pekerjaResponse->json();
                $pekerjas = $data['data'][0] ?? null;
            } else {
                Log::error('Failed to fetch pekerja data from API.', [
                    'status' => $pekerjaResponse->status(),
                    'response' => $pekerjaResponse->body(),
                ]);
            }
            return view('halamanResume.index4', [
                'pekerjaan' => $pekerjaan,
                'pekerjas' => $pekerjas,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error fetching combined data: " . $e->getMessage());
    
            return redirect()->back()->withErrors('An error occurred while fetching combined data.');
        }
    }

    public function getResume(Request $request)
    {
        try {
            $validated = $request->validate([
                'idPekerja' => 'required|integer',
            ]);
            $response = Http::post('http://localhost:3000/api/getResume', [
                'idPekerja' => $validated['idPekerja'],
            ]);

            if ($response->successful()) {
                $resume = $response->json()['data'][0] ?? [];
                return response()->json([
                    'success' => true,
                    'resume' => $resume,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch lamaran data from the API.',
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching lamaran data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching lamaran data.',
            ], 500);
        }
       
    }
}

