{{-- resources/views/admin/dashboard-admin.blade.php --}}

@include('admin.layouts.mold-dashboard-admin')

<section class="dashboard-content">
    <div class="dashboard-header">
        <h1 class="title">Dashboard</h1>
        <p class="update-date">
            <img src="{{ asset('images/iconstack.io - (Calendar)-grey.png') }}" alt="Update icon">
            Cập nhật: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </p>
    </div>

    <div class="charts-container" style="display: flex; justify-content: space-around; gap: 20px; flex-wrap: wrap; padding-bottom: 30px;">
    
        <div class="chart-wrapper" style="width: 400px;">
            <canvas id="bookStatusChart"></canvas>
        </div>

        <div class="chart-wrapper" style="width: 500px; text-align: center;">
            <h4 style="margin-bottom: 20px;">Top 5 Sách Mượn Nhiều Nhất</h4>
            <canvas id="topBooksChart"></canvas>
        </div>

    </div>




    <div class="cards">
        <div class="card">
            <div class="icon-box blue">
                <img src="{{ asset('images/iconstack.io - (Book 2).png') }}" alt="Book icon">
            </div>
            <div>
                <p class="label">Tổng số sách</p>
                <h2 id="totalBooks">{{ $totalBooks ?? 0 }}</h2>
            </div>
        </div>

        <div class="card">
            <div class="icon-box green">
                <img src="{{ asset('images/iconstack.io - (User)-white-admin.png') }}" alt="Readers icon">
            </div>
            <div>
                <p class="label">Độc giả đăng ký</p>
                <h2 id="totalReaders">{{ $totalReaders ?? 0 }}</h2>
            </div>
        </div>

        <div class="card">
            <div class="icon-box yellow">
                <img src="{{ asset('images/iconstack.io - (Bookmark)-thin-white.png') }}" alt="Borrow icon">
            </div>
            <div>
                <p class="label">Sách đang mượn</p>
                <h2 id="booksBorrowed">{{ $booksBorrowed ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>Tên độc giả</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Số sách mượn</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($readers as $r)
                <tr>
                    <td>{{ $r->hoTen }}</td>
                    <td>{{ $r->email }}</td>
                    <td>{{ $r->soDienThoai }}</td>
                    <td class="highlight">{{ $r->soSachDangMuon }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</section>

</main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctxBookStatus = document.getElementById('bookStatusChart').getContext('2d');
    const bookStatusChart = new Chart(ctxBookStatus, {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($bookStatusData)),
            datasets: [{
                data: @json(array_values($bookStatusData)),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    const ctxTopBooks = document.getElementById('topBooksChart').getContext('2d');
    const topBooksChart = new Chart(ctxTopBooks, {
        type: 'bar',
        data: {
            labels: @json($topBookLabels),
            datasets: [{
                label: 'Số lượt mượn',
                data: @json($topBookValues),
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    precision: 0
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>


</body>

</html>