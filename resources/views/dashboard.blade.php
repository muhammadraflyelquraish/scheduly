@extends('layouts.master')

@section('content')
<div class="wrapper wrapper-content">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Total Jadwal</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ number_format($totalSchedule, 0, ',', ' '); }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Total Dosen</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ number_format($totalDosen, 0, ',', ' '); }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Total Matkul</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ number_format($totalMatkul, 0, ',', ' '); }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Total Kelas</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ number_format($totalClass, 0, ',', ' '); }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Data Jadwal per Tahun Akademik
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div>
                            <canvas id="lineChart" height="140"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets') }}/js/plugins/chartJs/Chart.min.js"></script>
<script>
    $(document).ready(function() {

        var lineData = {
            labels: [],
            datasets: [{
                label: "Jumlah Jadwal",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: []
            }, {
                label: "Jumlah Dosen",
                backgroundColor: 'rgba(220, 220, 220, 0.5)',
                pointBorderColor: "#fff",
                data: []
            }]
        };

        var lineOptions = {
            responsive: true
        };

        var ctx = document.getElementById("lineChart").getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: lineData,
            options: lineOptions
        });

        $.ajax({
            url: "{{ route('dashboard.data') }}",
            type: "GET",
            dataType: 'JSON',
            success: function(res) {
                myChart.data.labels = res.scheduleLabels
                myChart.data.datasets[0].data = res.totalSchedule
                myChart.data.datasets[1].data = res.totalUser
                myChart.update();
            },
        })
    })
</script>
@endpush