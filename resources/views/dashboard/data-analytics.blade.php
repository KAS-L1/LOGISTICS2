@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')

    <div class="animate__animated p-6" :class="[$store.app.animation]">
        <div>
            <x-breadcrumbs :items="[
                ['label' => 'Home', 'route' => 'home'],
                ['label' => 'Data Analytics', 'route' => 'data-analytics'],
            ]" />

            <div class="pt-5">
                <h1>This is Data Analytics</h1>

                <div id="chart"
                    class="max-w-[40rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none p-5">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/requisitions-api')
                .then(response => response.json())
                .then(data => {
                    const apiRequisitions = data.data;

                    const categories = apiRequisitions.map(requisition => requisition.requisition_id);
                    const salesData = apiRequisitions.map(requisition => requisition.total_cost);

                    const options = {
                        chart: {
                            type: 'area',
                            height: 350,
                        },
                        stroke: {
                            curve: 'smooth',
                        },
                        series: [{
                            name: 'Sales',
                            data: salesData,
                        }],
                        xaxis: {
                            categories: categories,
                        },
                        colors: ['#2B9A10'],
                    };

                    const chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                })
                .catch(error => {
                    console.error('Error fetching requisition data:', error);
                });
        });
    </script>

@endsection
