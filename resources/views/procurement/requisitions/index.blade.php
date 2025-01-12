    @extends('layouts.master')
    @section('title', 'Purchase Requisition')

    @section('content')
        {{-- message --}}
        {!! Toastr::message() !!}

        <div class="animate__animated p-6" :class="[$store.app.animation]">
            <div>
                <x-breadcrumbs :items="[
                    ['label' => 'Home', 'route' => 'home'],
                    ['label' => 'Purchase Requisition', 'route' => 'requisitions.index'],
                ]" />

                <div class="pt-5">
                    <div class="panel">
                        <div class="table-responsive">
                            <table id="dataTable"
                                class="table-striped table-hover table-bordered  table-compact  dark:text-white-dark">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-checkbox" /></th>
                                        <th>ID</th>
                                        <th>Vendor Name</th>
                                        <th>Vendor Company</th>
                                        <th>Total Quantity</th>
                                        <th>Total Cost</th>
                                        <th>Total Price</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Created By</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requisitions as $requisition)
                                        <tr>
                                            <td><input type="checkbox" class="form-checkbox" /></td>
                                            <td>{{ $requisition->requisition_id }}</td>
                                            <td class="whitespace-nowrap">{{ $requisition->vendor->full_name }}</td>
                                            <td>{{ $requisition->vendor->company }}</td>
                                            <td class="whitespace-nowrap">{{ $requisition->total_quantity }}</td>
                                            <td class="whitespace-nowrap">{{ $requisition->total_cost }}</td>
                                            <td class="whitespace-nowrap">{{ $requisition->total_price }}</td>
                                            <td> <x-status-badge :status="$requisition->priority" :outline="true" />
                                            </td>
                                            <td>
                                                <x-status-badge :status="$requisition->status" />
                                            </td>

                                            {{-- <td>{{ $requisition->purchaseItems }}</td> --}}
                                            <td>{{ $requisition->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $requisition->creator->first_name }}</td>
                                            <td class="text-center">
                                                <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                                                    <a href="javascript:;" class="inline-block" @click="toggle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                            viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                                            <path
                                                                d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z" />
                                                        </svg>
                                                    </a>
                                                    <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                                        class="ltr:right-0 rtl:left-0">
                                                        <li><a href="javascript:;" @click="toggle">Download</a></li>
                                                        <li><a href="javascript:;" @click="toggle">Edit</a></li>
                                                        <li><a href="javascript:;" @click="toggle">View</a></li>
                                                        <li><a href="javascript:;" @click="toggle">Approve</a></li>
                                                        <li><a href="javascript:;" @click="toggle">Reject</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('requisitions.api') }}",
                columns: [{
                        data: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'requisition_id',
                        name: 'requisition_id'
                    },
                    {
                        data: 'vendor_name',
                        name: 'vendor.full_name'
                    },
                    {
                        data: 'vendor_company',
                        name: 'vendor.company'
                    },
                    {
                        data: 'total_quantity',
                        name: 'total_quantity'
                    },
                    {
                        data: 'total_cost',
                        name: 'total_cost'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
                    },
                    {
                        data: 'priority',
                        name: 'priority'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'created_by',
                        name: 'creator.first_name'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
