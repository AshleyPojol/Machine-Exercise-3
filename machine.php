<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>DHT Sensor Data</title>
</head>
<body>
    <!-- Vertical Navigation Bar -->
    <div class="sidebar">
        <ul class="nav">
            <li class="nav-item active" id="nav-table">Table</li>
            <li class="nav-item" id="nav-dashboard">Machine Learning 3</li> 
            <li class="nav-item" id="nav-dashboard">Pojol, Ashley</li> 
            <li class="nav-item" id="nav-dashboard">Villaflor, Angelo</li> 
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container" id="table-container">
            <h1>DHT Sensor Data</h1>
            <table id="sensorTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Timestamp</th>
                        <th>Temperature (°C)</th>
                        <th>Humidity (%)</th>
                    </tr>
                </thead>
                <tbody id="sensorData">
                    <!-- Data will be inserted here dynamically -->
                </tbody>
            </table>
            <div class="pagination" id="pagination">
                <!-- Pagination buttons will be inserted here dynamically -->
            </div>
        </div>
    </div>

    <!-- JavaScript to fetch and display table data -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchSensorData();
        });

        function fetchSensorData(page = 1) {
            var rowsPerPage = 15;
            var startIndex = (page - 1) * rowsPerPage;

            fetch('sensor_data.php?startIndex=' + startIndex + '&rowsPerPage=' + rowsPerPage)
                .then(response => response.json())
                .then(data => {
                    renderTable(data.data);
                    renderPagination(data.totalRows, page);
                });
        }

        function renderTable(data) {
            var tableBody = document.getElementById('sensorData');
            tableBody.innerHTML = '';

            data.forEach(row => {
                var tr = document.createElement('tr');
                tr.innerHTML = `<td>${row.id}</td><td>${row.timestamp}</td><td>${row.temperature}</td><td>${row.humidity}</td>`;
                tableBody.appendChild(tr);
            });
        }

        function renderPagination(totalRows, currentPage) {
            var rowsPerPage = 15;
            var totalPages = Math.ceil(totalRows / rowsPerPage);
            var paginationContainer = document.getElementById('pagination');
            paginationContainer.innerHTML = '';

            var leftArrow = document.createElement('button');
            leftArrow.innerHTML = '&lt;';
            leftArrow.classList.add('arrow');
            leftArrow.disabled = (currentPage == 1);
            leftArrow.onclick = function () {
                if (currentPage > 1) {
                    fetchSensorData(currentPage - 1);
                }
            };
            paginationContainer.appendChild(leftArrow);

            for (var i = 1; i <= totalPages; i++) {
                var button = document.createElement('button');
                button.textContent = i;
                button.classList.add('page-btn');
                if (i == currentPage) {
                    button.classList.add('active');
                }
                button.onclick = function () {
                    fetchSensorData(parseInt(this.textContent));
                };
                paginationContainer.appendChild(button);
            }

            var rightArrow = document.createElement('button');
            rightArrow.innerHTML = '&gt;';
            rightArrow.classList.add('arrow');
            rightArrow.disabled = (currentPage == totalPages);
            rightArrow.onclick = function () {
                if (currentPage < totalPages) {
                    fetchSensorData(currentPage + 1);
                }
            };
            paginationContainer.appendChild(rightArrow);
        }
    </script>
</body>
</html>
