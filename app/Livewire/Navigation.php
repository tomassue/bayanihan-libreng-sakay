<?php

namespace App\Livewire;

use App\Models\IndividualInformationModel;
use Livewire\Attributes\On;
use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div>
            <aside id="sidebar" class="sidebar" style="background-color: #0A335D; padding-right: unset;">
                <ul class="sidebar-nav" id="sidebar-nav">

                    <li class="nav-item">
                        <a class="nav-link collapsed fs-5" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#" aria-expanded="false" style="border-radius: unset;">
                            @php
                            $user_img = base64_encode(file_get_contents('assets/img/profile.png'));
                            @endphp
                            <img src="data:image/png;base64,{{ $user_img }}" alt="Profile" class="rounded-circle me-2" style="height: 50px; width: 50px;" />
                            <span class="text-truncate col-9">
                                @if (Auth::user()->user_id == 'ADMIN')
                                {{ Auth::user()->admin_information->name }}
                                @else
                                {{ Auth::user()->organization_information->organization_name }}
                                @endif
                            </span>
                        </a>
                        <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                            @if(Auth::user()->user_id == 'ADMIN')
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('change-password') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Change Password</span>
                                </a>
                            </li>
                            @endif

                            @if(Auth::user()->user_id !== 'ADMIN' && !session('default_password'))
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('update.profile') }}" style="color: white; color: white;padding-top: 2px; padding-bottom: 4px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Update Profile</span>
                                </a>
                            </li>
                            @endif

                            <li class="nav-item pt-0">
                                <a class="align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();" style="color: white; padding-top: 2px;">
                                    <span style="font-size: medium;">> &nbsp; Sign Out</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </li>

                    <hr style="color: #FFFFFF; margin-right: 20px;">

                    @if(!session('default_password'))
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link {{ request()->is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}" style="border-radius: unset;" wire:navigate>
                            <span class="fs-5 fw-bold">Dashboard</span>
                        </a>
                    </li>

                    @if(Auth::user()->user_id !== 'ADMIN')
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link {{ request()->is('registration') ? '' : 'collapsed' }}" href="{{ route('registration') }}" style="border-radius: unset;" wire:navigate>
                            <span class="fs-5 fw-bold">Registration</span>
                            <span class="ms-auto">
                                @livewire('SidebarNotificationIndicators.registrationnotificationindicator')
                            </span>
                        </a>
                    </li>
                    @else
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link {{ request()->is('registration', 'client-list') ? '' : 'collapsed' }}" data-bs-target="#registration-nav" data-bs-toggle="collapse" href="#" style="border-radius: unset;">
                            <span class="fs-5 fw-bold">Registration</span>
                        </a>
                        <ul id="registration-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('registration') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Organization</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('client-list') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Clients</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- /* -------------------------------------------------------------------------- */
                    /*                                 NEW PROCESS                                */
                    /* -------------------------------------------------------------------------- */ -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('np/registration') ? '' : 'collapsed' }}" href="{{ route('np_registration') }}" style="border-radius: unset;" wire:navigate>
                            <span class="fs-5 fw-bold">Registration</span>
                            
                            <span class="ms-auto">
                                @livewire('SidebarNotificationIndicators.registrationnotificationindicator')
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('np/register-rider') ? '' : 'collapsed' }}" href="{{ route('register-rider') }}" style="border-radius: unset;" wire:navigate wire:ignore.self>
                            <span class="fs-5 fw-bold">Rider (Approval)</span>
                            
                            <span class="ms-auto">
                            <span class="badge bg-white text-primary" style="color: rgb(10, 51, 93) !important; background-color: rgb(238, 238, 238) !important; display: {{ $this->loadRiderApproval() == '0' ? 'none' : 'inline-block' }}">{{ $this->loadRiderApproval() }}</span>
                            </span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('np/events') ? '' : 'collapsed' }}" href="{{ route('np_events') }}" style="border-radius: unset;" wire:navigate>
                            <span class="fs-5 fw-bold">Events</span>

                            <span class="ms-auto">
                                
                            </span>
                        </a>
                    </li>

                    @if(Auth::user()->email == 'superadmin@mail.com')
                    <!-- LINKS FOR SUPER ADMIN TESTING HERE -->
                    @endif
                    
                    <!-- /* -------------------------------------------------------------------------- */
                    /*                                 NEW PROCESS                                */
                    /* -------------------------------------------------------------------------- */ -->
                    @endif

                    <li class="nav-item" style="display: none">
                        <a class="nav-link {{ request()->is('events') ? '' : 'collapsed' }}" href="{{ route('events') }}" style="border-radius: unset;" wire:navigate>
                            <span class="fs-5 fw-bold">Events</span>

                            <span class="ms-auto">
                                @livewire('SidebarNotificationIndicators.eventsnotificationindicator')
                            </span>
                        </a>
                    </li>

                    @if(Auth::user()->user_id == 'ADMIN')
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link {{ request()->is('client-reports', 'org-reports', 'rider-reports', 'event-reports') ? '' : 'collapsed' }}" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#" style="border-radius: unset;">
                            <span class="fs-5 fw-bold">Reports</span>
                        </a>
                        <ul id="reports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                            @if(Auth::user()->user_id == 'ADMIN')
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('event-reports') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Events</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('client-reports') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Clients</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('org-reports') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Organization</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('rider-reports') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Riders</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('references') ? '' : 'collapsed' }}" href="{{ route('references') }}" style="border-radius: unset;" wire:navigate>
                            <span class="fs-5 fw-bold">Reference</span>
                        </a>
                    </li>

                    <!-- /* -------------------------------------------------------------------------- */
                    /*                                 NEW PROCESS                                */
                    /* -------------------------------------------------------------------------- */ -->
                    <li class="nav-item" style="display: {{ Auth::user()->admin_information->id == '1' || Auth::user()->admin_information->id == '2' ? 'block' : 'none' }}">
                        <a class="nav-link {{ request()->is('np/user-management', 'np/settings/user-management') ? '' : 'collapsed' }}" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#" style="border-radius: unset;">
                            <span class="fs-5 fw-bold">Settings</span>
                        </a>
                        <ul id="reports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('np_user_management') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; User Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- /* -------------------------------------------------------------------------- */
                    /*                                 NEW PROCESS                                */
                    /* -------------------------------------------------------------------------- */ -->

                    @else
                    <!-- <li class="nav-item">
                        <a class="nav-link {{ request()->is('indi-reports') ? '' : 'collapsed' }}" href="{{ route('indi-reports') }}" data-bs-target="#reports-nav-org" data-bs-toggle="collapse" style="border-radius: unset;">
                            <span class="fs-5 fw-bold">Reports</span>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('indi-reports', 'attendance-reports') ? '' : 'collapsed' }}" data-bs-target="#reports-nav-org" data-bs-toggle="collapse" href="#" style="border-radius: unset;">
                            <span class="fs-5 fw-bold">Reports</span>
                        </a>
                        <ul id="reports-nav-org" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                            @if(Auth::user()->user_id !== 'ADMIN')
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('indi-reports') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Riders</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="align-items-center" href="{{ route('attendance-reports') }}" style="color: white; padding-bottom: 2px;" wire:navigate>
                                    <span style="font-size: medium;">> &nbsp; Attendance</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @endif
                </ul>
            </aside>

            @assets
            <!-- Vendor JS Files -->
            <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
            <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
            <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

            <!-- You need this to perform scripts -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            @endassets

            <!-- Template Main JS File -->
            <script src="{{ asset('assets/js/main.js') }}"></script>
        </div>
        HTML;
    }

    public function boot()
    {
        $this->loadRiderApproval();
    }

    #[On('rider_approval_count')]
    public function loadRiderApproval()
    {
        $riderApprovalCount = IndividualInformationModel::join('users', 'users.user_id', '=', 'individual_information.user_id')
            ->where('users.status', 0)
            ->count();

        return $riderApprovalCount;
    }
}
