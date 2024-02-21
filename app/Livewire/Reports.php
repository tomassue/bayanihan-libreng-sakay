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
        $clients = ClientInformationModel::orderBy('created_at', 'DESC')
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

        // Fetch client's data
        $client_info = ClientInformationModel::where('id', $clientID)
            ->first();

        // Generate QR code
        $qrCode = QrCode::format('svg')
            ->size(195)
            ->errorCorrection('H')
            ->generate('QR ni!' . $clientID);

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'livewire.pdf-client-qr-code',
            [
                'qrCode'    => base64_encode($qrCode),
                'clientID'  => $clientID,
                'title'     => 'myQR' . $clientID,
                'full_name' => $client_info->first_name . ' ' . $client_info->middle_name . ' ' . $client_info->last_name,
            ]
        )
            // ->setPaper($customPaper)
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('myQR.pdf');

        // return view('livewire.pdf-client-qr-code', [
        //     'qrCode'    => base64_encode($qrCode),
        //     'clientID'  => $clientID,
        //     'title'     => 'myQR' . $clientID,
        //     'full_name' => $client_info->first_name . ' ' . $client_info->middle_name . ' ' . $client_info->last_name,
        // ]);
    }
}
