<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PerusahaanController extends Controller
{
    private $nodeApiBaseUrl = 'http://localhost:3000/api';
    public function storePerusahaan(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'username' => 'required|string',
            'nomorHP'=>'required|string',
            'namaBisnis'=>'required|string',
        ]);

        $response = Http::post('http://localhost:3000/api/storePerusahaan', [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'username' => $validated['username'],
            'nomorHP' => $validated['nomorHP'],
            'namaBisnis' => $validated['namaBisnis'],
        ]);

        if ($response->successful()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perusahaan created successfully!',
                ]);
            }
            return redirect()->route('workersunion.logInPerusahaanIndex')->with('success', 'Pekerja created successfully!');
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


    public function checkEmailPerusahaan(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        Log::info('Validated email for checkEmail', ['email' => $validated['email']]);

        $response = Http::post('http://localhost:3000/api/checkEmailPerusahaan', [
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
    public function daftarPerusahaanIndex()
    {
        $response = Http::post('http://localhost:3000/api/getDataPekerja', [
            'idPekerja' => session('idPekerja')
        ]);

        $data = $response->json(); // Decode the response JSON
        $pekerjas = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['pekerjas' => $pekerjas]);
        return view('daftar_perusahaan.index', ['pekerjas' => $pekerjas]);
    }
    public function logInPerusahaanIndex()
    {
        return view('login_perusahaan.index');
    }
    public function logInPerusahaan(Request $request)
    {
        Log::info('Login request received', [
            'email' => $request->input('email'),
            'password' => $request->input('password'), 
        ]);
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $response = Http::post('http://localhost:3000/api/verifyPasswordPerusahaan', [
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
                session(['idPerusahaan' => $data['user']['idPerusahaan']]);
                session()->forget('idPekerja');
                return response()->json([
                    'success' => true,
                    'password' =>true,
                    'redirect' => route('workersunion.homepagePerusahaanIndex'), 
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

    public function homepagePerusahaanIndex()
    {
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        Log::info('API Response Data:', ['asdasdasd' => $data]);
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);
        return view('homepage_perusahaan.index', ['perusahaans' => $perusahaans]);
    }
    public function postingPekerjaanPage1()
    {
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);
        return view('posting_pekerjaan.index1', ['perusahaans' => $perusahaans]);
    }
    public function postingPekerjaanStorePage1(Request $request)
{
    Log::info('Incoming request:', $request->all());

    $validated = $request->validate([
        'judulPekerjaan' => 'required|string',
        'lokasiPekerjaan' => 'required|string',
        'kategoriJabatan' => 'required|string',
        'kategoriGaji' => 'required|string',
        'jenisGaji' => 'required|string',
        'kisaranGaji' => 'required|string',
    ]);

    session()->put('postingPekerjaanPage1', $validated);

    if (session()->has('postingPekerjaanPage1')) {
        Log::info('Session data stored:', session('postingPekerjaanPage1'));
        return response()->json([
            'success' => true,
            'message' => 'Data successfully stored in session.',
            'redirect' => route('workersunion.postingPekerjaanPage2'),
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Failed to store data in session.',
        ], 500);
    }
}

    public function postingPekerjaanPage2()
    {
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);
        return view('posting_pekerjaan.index2', ['perusahaans' => $perusahaans]);
    }
    public function postingPekerjaanPage3()
    {
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);
        return view('posting_pekerjaan.index3', ['perusahaans' => $perusahaans]);
    }
    public function postingPekerjaanStorePage3(Request $request)
{
    Log::info('Incoming request for Page 3:', $request->all());

    $validated = $request->validate([
        'bannerPerusahaan' => 'required|string',
        'deskripsiPerusahaan' => 'required|string',
        'linkReferensi' => 'required|string',
    ]);

    session()->put('postingPekerjaanPage3', $validated);

    if (session()->has('postingPekerjaanPage3')) {
        Log::info('Session data for Page 3 stored:', session('postingPekerjaanPage3'));
        return response()->json([
            'success' => true,
            'message' => 'Data successfully stored in session.',
            'redirect' => route('workersunion.postingPekerjaanPage4'),
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Failed to store data in session.',
        ], 500);
    }
}

public function postingPekerjaanStorePage4(Request $request)
{
    Log::info('Incoming request for Page 4:', $request->all());

    $validated = $request->validate([
        'pertanyaan' => 'required|string',
    ]);

    session()->put('postingPekerjaanPage4', $validated);

    if (session()->has('postingPekerjaanPage4')) {
        Log::info('Session data for Page 4 stored:', session('postingPekerjaanPage4'));
        return response()->json([
            'success' => true,
            'message' => 'Data successfully stored in session.',
            'redirect' => route('workersunion.postingPekerjaanPage5'),
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Failed to store data in session.',
        ], 500);
    }
}

    public function postingPekerjaanPage4()
    {
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);
        return view('posting_pekerjaan.index4', ['perusahaans' => $perusahaans]);
    }
    public function postingPekerjaanPage5()
{   
    $idPerusahaan = session('idPerusahaan');
    $page1Data = session()->get('postingPekerjaanPage1');
    $page3Data = session()->get('postingPekerjaanPage3');
    $page4Data = session()->get('postingPekerjaanPage4');

    Log::info('ALL DATA KASNLANSLD', [
        'page1Data' => $page1Data,
        'page3Data' => $page3Data,
        'page4Data' => $page4Data,
    ]);
    if (!$page1Data || !$page3Data || !$page4Data) {
        Log::error('Data incomplete.', [
            'page1Data' => $page1Data,
            'page3Data' => $page3Data,
            'page4Data' => $page4Data,
        ]);
        return redirect()->route('workersunion.postingPekerjaanPage1')->withErrors('Data incomplete. Please complete all pages.');
    }

    $combinedData = array_merge(['idPerusahaan' => $idPerusahaan], $page1Data, $page3Data, $page4Data);
    Log::info('Flattened Data for API:', $combinedData);
    $uploadResponse = Http::post('http://localhost:3000/api/uploadPekerjaan', $combinedData);

    if (!$uploadResponse->successful()) {
        return redirect()->route('workersunion.postingPekerjaanPage4')->withErrors('Failed to upload job posting. Please try again.');
    }

        session()->forget(['postingPekerjaanPage1', 'postingPekerjaanPage3', 'postingPekerjaanPage4']);

        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => $idPerusahaan
        ]);

        $data = $response->json(); // Decode the response JSON
        $perusahaans = isset($data['data']) ? $data['data'] : null;
        Log::info('All', [
            'page1Data' => $page1Data,
            'page3Data' => $page3Data,
            'page4Data' => $page4Data,
        ]);
        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);
        return view('posting_pekerjaan.index5', ['perusahaans' => $perusahaans]);
    }
    public function getPekerjaan(Request $request){
        $idPerusahaan = session('idPerusahaan') ?? $request->input('idPerusahaan');

        if (!$idPerusahaan) {
            return response()->json([
                'success' => false,
                'message' => 'idPerusahaan is required.',
            ], 400);
        }

        try {
            $response = Http::post("http://localhost:3000/api/getPekerjaan", [
                'idPerusahaan' => $idPerusahaan,
            ]);
            Log::info('Incoming request datssdsa', $response->json()['pekerjaans'] ?? []);
            if ($response->successful()) {
                $pekerjaans = $response->json()['pekerjaans'] ?? [];

                return response()->json([
                    'success' => true,
                    'pekerjaans' => $pekerjaans,
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
    public function getPekerjaanById(Request $request)
    {
        $validated = $request->validate([
            'idPekerjaan' => 'required|integer', 
        ]);

        try {
            $response = Http::post("http://localhost:3000/api/getPekerjaanById", [
                'idPekerjaan' => $validated['idPekerjaan'],
            ]);
            if ($response->successful()) {
                $pekerjaans = $response->json()['pekerjaans'] ?? []; 
                return response()->json([
                    'success' => true,
                    'pekerjaans' => $pekerjaans,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pekerjaan data from API.',
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching pekerjaan data.',
            ], 500);
        }
    }

    public function akunPerusahaanIndex()
    {
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        Log::info('API Response Data:', ['data' => $data]);

        // Ensure $perusahaans is an array or empty if no data is found
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        return view('akunPerusahaan.index', ['perusahaans' => $perusahaans]);
    }

    public function updatePerusahaan(Request $request){
        $validated = $request->validate([//username,nomorHP,kontakUtama, alamatPerusahaan, emailPenagihan, logoPerusahaan
            'nomorHP' => 'nullable|string',
            'kontakUtama' => 'nullable|string',
            'alamatPerusahaan' => 'nullable|string',
            'emailPenagihan'=>'nullable|string',
            'logoPerusahaan' => 'nullable|string',
        ]);

        Log::info('Incoming request data', $validated);

        $response = Http::post('http://localhost:3000/api/updatePerusahaan', array_merge($validated, [
            'idPerusahaan' => session('idPerusahaan'),
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

    public function storeJobSession(Request $request)
    {
        $validated = $request->validate([
            'idPekerjaan' => 'required|integer',
        ]);

        // Store the job ID in the session
        session(['idPekerjaan' => $validated['idPekerjaan']]);

        return response()->json([
            'success' => true,
            'message' => 'Job ID stored successfully.',
        ]);
    }
    public function halamanResume()
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
            return view('halamanResume.index1', [
                'pekerjaan' => $pekerjaan,
                'pekerjas' => $pekerjas,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error fetching combined data: " . $e->getMessage());
    
            return redirect()->back()->withErrors('An error occurred while fetching combined data.');
        }
    }

    public function pekerjaanPerusahaan(){
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        Log::info('API Response Data:', ['asdasdasd' => $data]);
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);

        return view('pekerjaanPerusahaan.indexbuka', ['perusahaans' => $perusahaans]);
    }

    public function getPekerjaanAndLamaran(Request $request){
        $validated = $request->validate([
            'idPekerjaan' => 'required|integer',

        ]);
        $pekerjaanResponse = Http::post('http://localhost:3000/api/getPekerjaanAndLamaran', array_merge($validated, [
            'idPerusahaan' => session('idPerusahaan'),
        ]));
        $pekerjaan = null;
        if ($pekerjaanResponse->successful()) {
            $data = $pekerjaanResponse->json();
            $pekerjaan = $data['pekerjaans'][0] ?? null;
            return response()->json([
                'success' => true,
                'pekerjaan' => $pekerjaan,
            ]);
        } else {
            Log::error('Failed to fetch pekerja data from API.', [
                'status' => $pekerjaanResponse->status(),
                'response' => $pekerjaanResponse->body(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching skills.',
            ], 500);
        }
    }

    public function pekerjaanPerusahaanKandidat(Request $request){
        $response = Http::post('http://localhost:3000/api/getDataPerusahaan', [
            'idPerusahaan' => session('idPerusahaan')
        ]);

        $data = $response->json(); // Decode the response JSON
        Log::info('API Response Data:', ['asdasdasd' => $data]);
        $perusahaans = isset($data['data']) ? $data['data'] : null;

        Log::info('Extracted User Data:', ['perusahaans' => $perusahaans]);

        return view('pekerjaanPerusahaan.indexkandidat', ['perusahaans' => $perusahaans]);
    }
    public function getLamaran()
    {
        try {
            $response = Http::get('http://localhost:3000/api/getLamaran');

            if ($response->successful()) {
                $lamaran = $response->json()['lamaran'] ?? [];
                return response()->json([
                    'success' => true,
                    'lamaran' => $lamaran,
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

    public function handleLamaran(Request $request)
    {
        $validated = $request->validate([
            'idLamaran' => 'required|integer',
            'status' => 'required|in:diterima,ditolak',
        ]);

        try {
            $response = Http::post('http://localhost:3000/api/handleLamaran', [
                'idLamaran' => $validated['idLamaran'],
                'status' => $validated['status'],
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lamaran action processed successfully.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to handle lamaran action.',
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error handling lamaran action: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the action.',
            ], 500);
        }
    }
}
