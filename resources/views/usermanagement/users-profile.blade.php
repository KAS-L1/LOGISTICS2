@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="animate__animated p-6" :class="[$store.app.animation]">
        <!-- start main content section -->
        <div>
            <ul class="flex space-x-2 rtl:space-x-reverse">
                <li>
                    <a href="javascript:;" class="text-primary hover:underline">Users</a>
                </li>
                <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                    <span>Profile</span>
                </li>
            </ul>
            <div class="pt-5">
                <div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-3 xl:grid-cols-4">
                    <div class="panel">
                        <div class="mb-5 flex items-center justify-between">
                            <h5 class="text-lg font-semibold dark:text-white-light">Profile</h5>
                        </div>
                        <div class="mb-5">
                            <div class="flex flex-col items-center justify-center">
                                <img src="{{ auth()->check() && auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : asset('assets/images/default-profile.png') }}"
                                    alt="image" class="mb-5 h-24 w-24 rounded-full object-cover">
                                <p class="text-xl font-semibold text-primary">{{ auth()->user()->first_name }}
                                    {{ auth()->user()->last_name }}</p>
                            </div>
                            <ul class="m-auto mt-5 flex max-w-[160px] flex-col space-y-4 font-semibold text-white-dark">
                                <li class="flex items-center gap-2">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0">
                                        <path
                                            d="M2.3153 12.6978C2.26536 12.2706 2.2404 12.057 2.2509 11.8809C2.30599 10.9577 2.98677 10.1928 3.89725 10.0309C4.07094 10 4.286 10 4.71612 10H15.2838C15.7139 10 15.929 10 16.1027 10.0309C17.0132 10.1928 17.694 10.9577 17.749 11.8809C17.7595 12.057 17.7346 12.2706 17.6846 12.6978L17.284 16.1258C17.1031 17.6729 16.2764 19.0714 15.0081 19.9757C14.0736 20.6419 12.9546 21 11.8069 21H8.19303C7.04537 21 5.9263 20.6419 4.99182 19.9757C3.72352 19.0714 2.89681 17.6729 2.71598 16.1258L2.3153 12.6978Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path opacity="0.5"
                                            d="M17 17H19C20.6569 17 22 15.6569 22 14C22 12.3431 20.6569 11 19 11H17.5"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path opacity="0.5"
                                            d="M10.0002 2C9.44787 2.55228 9.44787 3.44772 10.0002 4C10.5524 4.55228 10.5524 5.44772 10.0002 6"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M4.99994 7.5L5.11605 7.38388C5.62322 6.87671 5.68028 6.0738 5.24994 5.5C4.81959 4.9262 4.87665 4.12329 5.38382 3.61612L5.49994 3.5"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M14.4999 7.5L14.6161 7.38388C15.1232 6.87671 15.1803 6.0738 14.7499 5.5C14.3196 4.9262 14.3767 4.12329 14.8838 3.61612L14.9999 3.5"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                    {{ auth()->user()->getRoleNames()->join(', ') }}
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0">
                                        <path
                                            d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path opacity="0.5" d="M7 4V2.5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M17 4V2.5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M2 9H22" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                    </svg>
                                    {{ auth()->user()->status }}
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0">
                                        <path opacity="0.5"
                                            d="M4 10.1433C4 5.64588 7.58172 2 12 2C16.4183 2 20 5.64588 20 10.1433C20 14.6055 17.4467 19.8124 13.4629 21.6744C12.5343 22.1085 11.4657 22.1085 10.5371 21.6744C6.55332 19.8124 4 14.6055 4 10.1433Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <circle cx="12" cy="10" r="3" stroke="currentColor"
                                            stroke-width="1.5"></circle>
                                    </svg>
                                    {{ auth()->user()->address }}
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center gap-2">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0">
                                            <path opacity="0.5"
                                                d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12Z"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                            <path
                                                d="M6 8L8.1589 9.79908C9.99553 11.3296 10.9139 12.0949 12 12.0949C13.0861 12.0949 14.0045 11.3296 15.8411 9.79908L18 8"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                        <span class="truncate text-primary">{{ auth()->user()->email }}</span></a>
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                        <path
                                            d="M16.1007 13.359L16.5562 12.9062C17.1858 12.2801 18.1672 12.1515 18.9728 12.5894L20.8833 13.628C22.1102 14.2949 22.3806 15.9295 21.4217 16.883L20.0011 18.2954C19.6399 18.6546 19.1917 18.9171 18.6763 18.9651M4.00289 5.74561C3.96765 5.12559 4.25823 4.56668 4.69185 4.13552L6.26145 2.57483C7.13596 1.70529 8.61028 1.83992 9.37326 2.85908L10.6342 4.54348C11.2507 5.36691 11.1841 6.49484 10.4775 7.19738L10.1907 7.48257"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path opacity="0.5"
                                            d="M18.6763 18.9651C17.0469 19.117 13.0622 18.9492 8.8154 14.7266C4.81076 10.7447 4.09308 7.33182 4.00293 5.74561"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path opacity="0.5"
                                            d="M16.1007 13.3589C16.1007 13.3589 15.0181 14.4353 12.0631 11.4971C9.10807 8.55886 10.1907 7.48242 10.1907 7.48242"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                    <span class="whitespace-nowrap" dir="ltr">{{ auth()->user()->contact }}</span>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="panel lg:col-span-2 xl:col-span-3">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                            class="mb-5 rounded-md dark:border-[#191e3a] dark:bg-[#0e1726]">
                            @csrf
                            <h6 class="mb-5 text-lg font-bold">General Information</h6>

                            @if (session('success'))
                                <div class="alert alert-success mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger mb-4">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row">
                                <!-- File Upload Container -->
                                <div class="relative mx-auto">
                                    <img id="profilePreview"
                                        src="{{ auth()->check() && auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : asset('assets/images/default-profile.png') }}"
                                        alt="Profile Picture"
                                        class="h-32 w-32 rounded-full object-cover mb-3 border-2 border-gray-300 dark:border-gray-700">
                                    <input id="profileImageInput" type="file" name="profile_picture" accept="image/*"
                                        class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                                <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2 ml-2">
                                    <div>
                                        <label for="first_name">First Name</label>
                                        <input id="first_name" name="first_name" type="text"
                                            value="{{ old('first_name', auth()->user()->first_name) }}"
                                            class="form-input">
                                    </div>
                                    <div>
                                        <label for="last_name">Last Name</label>
                                        <input id="last_name" name="last_name" type="text"
                                            value="{{ old('last_name', auth()->user()->last_name) }}" class="form-input">
                                    </div>
                                    <div>
                                        <label for="username">Username</label>
                                        <input id="username" name="username" type="text"
                                            value="{{ old('username', auth()->user()->username) }}" class="form-input">
                                    </div>
                                    <div>
                                        <label for="email">Email</label>
                                        <input id="email" name="email" type="email"
                                            value="{{ auth()->user()->email }}" class="form-input" readonly>
                                    </div>
                                    <div>
                                        <label for="company">Company</label>
                                        <input id="company" name="company" type="text"
                                            value="{{ old('company', auth()->user()->company) }}" class="form-input">
                                    </div>
                                    <div>
                                        <label for="contact">Contact</label>
                                        <input id="contact" name="contact" type="text"
                                            value="{{ old('contact', auth()->user()->contact) }}" class="form-input">
                                    </div>
                                    <div>
                                        <label for="address">Address</label>
                                        <input id="address" name="address" type="text"
                                            value="{{ old('address', auth()->user()->address) }}" class="form-input">
                                    </div>
                                    <div>
                                        <label for="status">Status</label>
                                        <select id="status" name="status" class="form-select text-white-dark">
                                            <option value="active"
                                                {{ old('status', auth()->user()->status) == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ old('status', auth()->user()->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                    <div class="mt-3 sm:col-span-2">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end main content section -->
    </div>
@endsection
