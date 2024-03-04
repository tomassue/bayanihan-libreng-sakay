<?php

namespace App\Livewire;

use App\Models\ClientInformationModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

#[Layout('components.layouts.page')]
#[Title('Reports')]

class Reports extends Component
{
    use WithPagination;

    // Function encrypt($text_data)
    private string $encryptMethod = 'AES-256-CBC';
    private string $key;
    private string $iv;

    public function render()
    {
        $clients = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'users.contactNumber AS contact_number', 'client_information.*')
            ->orderBy('created_at', 'DESC')
            ->paginate(10, pageName: 'list-of-clients');

        return view('livewire.reports', [
            'clients'                   =>      $clients,
            'currentPageclients'        =>      $clients->currentPage(),
            'totalPagesclients'         =>      $clients->lastPage(),
            'totalRecordsclients'       =>      $clients->total(),
            'noRecordsclients'          =>      $clients->isEmpty(),
        ]);
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

    public function generateQr($clientID)
    {
        // Paper Size
        $customPaper = array(0, 0, 1248, 816);

        // Decrypt the url we just encrypted in our route
        $clientID = decrypt($clientID);

        // Fetch client's data
        $client_info = ClientInformationModel::where('client_information.id', $clientID)
            ->join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select('users.id AS userID', 'users.contactNumber AS contact_number', 'client_information.*')
            ->first();

        // Encrypt fetched data
        $u_id   = $clientID;
        $f_name = str_replace(',', '|', $client_info->first_name . ' ' . $client_info->middle_name . ' ' . $client_info->last_name . ' ' . $client_info->ext_name);
        $c_number = $client_info->contact_number;

        $to_incrypt = $u_id . ',' . $f_name . ',' . $c_number;
        $value = $this->encrypt($to_incrypt);

        // Generate QR code
        $qrCode = QrCode::format('svg')
            ->size(195)
            ->errorCorrection('H')
            ->generate($value);

        // Logos to base64
        $cdo_seal = public_path('assets/img/cdo-seal.png');
        $mayor    = public_path('assets/img/MAYOR.png');
        $rise     = public_path('assets/img/rise.png');

        $cdo_seal64 = base64_encode(file_get_contents($cdo_seal));
        $mayor64    = base64_encode(file_get_contents($mayor));
        $rise64     = base64_encode(file_get_contents($rise));

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'livewire.pdf-client-qr-code',
            [
                'cdo_seal'  => $cdo_seal64,
                'mayor'     => $mayor64,
                'rise'      => $rise64,

                'qrCode'    => base64_encode($qrCode),
                'clientID'  => $clientID,
                'title'     => 'myQR' . $clientID,
                'full_name' => $client_info->last_name . ', ' . $client_info->first_name . ($client_info->middle_name ? ' ' . $client_info->middle_name : '') . ($client_info->ext_name ? ' ' . $client_info->middle_name . '.' : ''),
            ]
        )
            // ->setPaper($customPaper)
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('myQR.pdf');

        // return view('livewire.pdf-client-qr-code', [
        //     'cdo_seal'  => $cdo_seal64,
        //     'mayor'     => $mayor64,
        //     'rise'      => $rise64,
        //     'qrCode'    => base64_encode($qrCode),
        //     'clientID'  => $clientID,
        //     'title'     => 'myQR' . $clientID,
        //     'full_name' => $client_info->first_name . ' ' . $client_info->middle_name . ' ' . $client_info->last_name,
        // ]);
    }
}
