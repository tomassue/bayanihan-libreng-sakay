<?php

namespace App\Http\Controllers;

use App\Models\ClientInformationModel;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateClientQRController extends Controller
{
    // Function encrypt($text_data)
    private string $encryptMethod = 'AES-256-CBC';
    private string $key;
    private string $iv;

    /**
     * Display a listing of the resource.
     */
    public function index($ClientUserID)
    {
        // dd($ClientUserID);

        $ClientUserID = decrypt($ClientUserID);

        $client = ClientInformationModel::where('user_id', $ClientUserID)
            ->first();

        // dd($client->id);

        // Encrypt fetched data
        $u_id   = $client->id;
        $f_name = str_replace(',', '|', $client->first_name . ' ' . $client->middle_name . ' ' . $client->last_name . ' ' . $client->ext_name);
        $c_number = $client->contact_number;

        $to_incrypt = $u_id . ',' . $f_name . ',' . $c_number;
        $value = $this->encrypt($to_incrypt);

        // Generate QR code
        $qrCode = QrCode::format('svg')
            ->size(195)
            ->errorCorrection('H')
            ->generate($value);

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'livewire.pdf-client-qr-code',
            [
                'qrCode'    => base64_encode($qrCode),
                'clientID'  => $client->id,
                'title'     => 'myQR' . $client->id,
                'full_name' => $client->last_name . ', ' . $client->first_name . ($client->middle_name ? ' ' . $client->middle_name : '') . ($client->ext_name ? ' ' . $client->middle_name . '.' : ''),
            ]
        )
            // ->setPaper($customPaper)
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('myQR.pdf');
    }

    private function encrypt($text_data): string
    {
        $mykey = 'CagayanDeOroIctQrCode';
        $myiv = 'ThisIsASecuredBlock';
        $this->key = substr(hash('sha256', $mykey), 0, 32);
        $this->iv = substr(hash('sha256', $myiv), 0, 16);
        $ciphertext_raw = openssl_encrypt($text_data, $this->encryptMethod, $this->key, 0, $this->iv);

        return $ciphertext_raw;
    }

    public function generateQRPage($ClientUserID)
    {
        // $this->index($ClientUserID);

        return view('get-qr-client-register', [
            'ClientUserID'  => $ClientUserID,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
