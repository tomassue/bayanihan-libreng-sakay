<?php

namespace App\Livewire;

use App\Exports\ReportClientExport;
use App\Models\ClientInformationModel;
use App\Models\TransactionModel;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Validate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Registration')]

class Reports extends Component
{
    use WithPagination;

    // Add Client Modal
    public $middle_name, $ext_name, $school;

    #[Validate('required')]
    public $user_type, $last_name, $first_name, $birthday, $sex, $address, $emergency_name;

    #[Validate('required|size:11|unique:users,contactNumber')]
    public $contact_number;

    #[Validate('required|size:11')]
    public $emergency_contact_no = '';

    // Transaction History
    public $id_client;

    // Search and Filter
    public $search_client = '', $start_date = '', $end_date = '';

    // Function encrypt($text_data)
    private string $encryptMethod = 'AES-256-CBC';
    private string $key;
    private string $iv;

    public function render()
    {
        $query = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'users.contactNumber AS contact_number', 'client_information.*')
            ->where('first_name', 'like', '%' . $this->search_client . '%')
            ->orWhere('middle_name', 'like', '%' . $this->search_client . '%')
            ->orWhere('last_name', 'like', '%' . $this->search_client . '%')
            ->orWhere('ext_name', 'like', '%' . $this->search_client . '%')
            ->orderBy('created_at', 'DESC');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('client_information.created_at', [$this->start_date, $this->end_date]);
        }

        $clients = $query->paginate(10, pageName: 'list-of-clients');

        $client_details = ClientInformationModel::leftJoin('school_information', 'client_information.id_school', '=', 'school_information.id')
            ->where('client_information.id', $this->id_client)
            ->select(
                DB::raw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(last_name, ''), ' ', COALESCE(ext_name, '')) AS client_fullname"),
                'sex',
                DB::raw("DATE_FORMAT(birthday, '%b %d, %Y') AS birthday"),
                'address',
                DB::raw("COALESCE(school_information.school_name, '') AS school"),
                'guardian_name',
                'guardian_contact_number'
            )
            ->first();

        $client_transact = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', 'event_organization_riders.id')
            ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
            ->join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
            ->join('events', 'event_organizations.id_event', '=', 'events.id')
            ->select(
                'events.event_name AS event_name',
                'events.event_date AS event_date',
                'events.event_location AS event_location',
                DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_name"),
                'transactions.destination AS transaction_destination',
                DB::raw("DATE_FORMAT(transactions.created_at, '%h:%i%p') AS transaction_time"),
                DB::raw("DATE_FORMAT(transactions.created_at, '%b %d, %Y') AS transaction_date"),
                'transactions.status AS status',
                'transactions.destination AS destination',
                DB::raw("DATE_FORMAT(transactions.updated_at, '%b %d, %Y %h:%i%p') AS time_drop"),
            )
            ->where('id_client', $this->id_client)
            ->orderBy('transactions.created_at', 'DESC')
            ->get();

        return view('livewire.reports', [
            'clients'                   =>      $clients,
            'currentPageclients'        =>      $clients->currentPage(),
            'totalPagesclients'         =>      $clients->lastPage(),
            'totalRecordsclients'       =>      $clients->total(),
            'noRecordsclients'          =>      $clients->isEmpty(),

            'client_transact'           =>      $client_transact,
            'client_details'            =>      $client_details
        ]);
    }

    public function clear()
    {
        $this->search_client = "";
        $this->start_date = "";
        $this->end_date = "";
    }

    public function search()
    {
        $this->resetPage();
    }

    public function transactHistory($id)
    {
        $this->id_client = $id;
    }

    public function updating()
    {
        $this->resetPage('list-of-clients');
    }

    public function updatedUserType($value) // To achieve the behavior where the selected value in the "School" input field is reset to null if the user selects an option other than "Student" or "School Staff", you can utilize Livewire's lifecycle hooks to reset the value of the "School" input field when the "User Type" input field changes.  
    { // In the updatedUserType method, we listen for changes in the "User Type" input field. If the selected value is not "Student" or "School Staff", we reset the value of the "School" input field to null. Now, whenever the user selects an option other than "Student" or "School Staff" in the "User Type" select field, the value of the "School" select field will be automatically reset to null, reducing the chance of human error.
        if (!in_array($value, ['student', 'school_staff'])) {
            $this->school = null;
        }
    }

    public function saveClient()
    {
        $this->validate();

        # Generate random letters and numbers for user_id
        $timestamp = now()->timestamp;
        $randomString = Str::random(10);
        $user_id = strtoupper($timestamp . $randomString);

        ClientInformationModel::create([
            'user_id'                   => $user_id,
            'user_type'                 => $this->user_type,
            'last_name'                 => $this->last_name,
            'first_name'                => $this->first_name,
            'middle_name'               => $this->middle_name,
            'ext_name'                  => $this->ext_name,
            'sex'                       => $this->sex,
            'birthday'                  => $this->birthday,
            'address'                   => $this->address,
            'id_school'                 => $this->school,
            'guardian_name'             => $this->emergency_name,
            'guardian_contact_number'   => $this->emergency_contact_no,
        ]);

        User::create([
            'user_id'                   => $user_id,
            'email'                     => 'null',
            'contactNumber'             => $this->contact_number,
            'id_account_type'           => '3',
            'password'                  => 'null',
            'status'                    =>  '1',
        ]);

        $this->dispatch('close-addClientModal-Modal');
        session()->flash('status', 'Client added successfully.');
        return redirect()->to('client-list');
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
                'full_name' => $client_info->last_name . ', ' . $client_info->first_name . ($client_info->middle_name ? ' ' . $client_info->middle_name : '') . ($client_info->ext_name ? ' ' . $client_info->ext_name . '.' : ''),
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

    public function printPDF($start_date = '', $end_date = '', $search_client = '')
    {
        # Replace 'null' values with empty string
        $start_date = ($start_date === 'null') ? '' : $start_date;
        $end_date = ($end_date === 'null') ? '' : $end_date;
        $search_client = ($search_client === 'null') ? '' : $search_client;

        $query = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'users.contactNumber AS contact_number', 'client_information.*')
            ->where('first_name', 'like', '%' . $search_client . '%')
            ->orWhere('middle_name', 'like', '%' . $search_client . '%')
            ->orWhere('last_name', 'like', '%' . $search_client . '%')
            ->orWhere('ext_name', 'like', '%' . $search_client . '%')
            ->orderBy('created_at', 'DESC');

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('client_information.created_at', [$start_date, $end_date]);
        }

        $clients = $query->get();

        // Logos to base64
        $bls_logo = public_path('assets/img/copy2.png');
        $city_logo = public_path('assets/img/cdo-seal.png');
        $rise_logo = public_path('assets/img/rise.png');

        $bls_logo64 = base64_encode(file_get_contents($bls_logo));
        $city_logo64 = base64_encode(file_get_contents($city_logo));
        $rise_logo64 = base64_encode(file_get_contents($rise_logo));

        $pdf = PDF::loadView(
            'pdf-reports.report-clients-pdf',
            [
                'bls_logo'          => $bls_logo64,
                'city_logo'         => $city_logo64,
                'rise_logo'         => $rise_logo64,
                'start_date'        => $start_date,
                'end_date'          => $end_date,
                'clients'           => $clients

            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream();
    }

    public function export()
    {
        $start_date     = $this->start_date;
        $end_date       = $this->end_date;
        $search_client  = $this->search_client;

        return Excel::download(new ReportClientExport($start_date, $end_date, $search_client), 'clientreport.xlsx');
    }
}
