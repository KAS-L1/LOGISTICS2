@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}

    <div class="animate__animated p-6" :class="[$store.app.animation]">
        <div>
            <x-breadcrumbs :items="[
                ['label' => 'Home', 'route' => 'home'],
                ['label' => 'Data Analytics', 'route' => 'data-analytics'],
                ['label' => 'Predictive Analytics', 'route' => 'predictive-analytics'],
            ]" />

            <div class="pt-5">
                <h1>Dashboard</h1>

                <div id="chart"
                    class="max-w-[40rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none p-5">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch requisition data from the backend
            fetch('/requisitions')
                .then(response => response.json())
                .then(data => {
                    // Assuming 'data' contains requisition data
                    const requisitions = data.data; // Page of requisitions

                    // Extract data for the chart
                    const categories = requisitions.map(requisition => requisition.requisition_id);
                    const salesData = requisitions.map(requisition => requisition.total_cost);

                    var options = {
                        chart: {
                            type: 'area',
                            height: 350, // Ensure a proper height for the chart
                        },
                        stroke: {
                            curve: 'smooth',
                        },
                        series: [{
                            name: 'Sales',
                            data: salesData, // Using total_cost data
                        }],
                        xaxis: {
                            categories: categories, // Using requisition IDs as categories
                        },
                        colors: ['#2B9A10'], // Set success color (green)
                    };

                    // Render the chart with the fetched data
                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                })
                .catch(error => {
                    console.error('Error fetching requisition data:', error);
                });
        });
    </script>

@endsection
