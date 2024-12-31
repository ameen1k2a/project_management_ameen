<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Project Management - Ameen</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  
  <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="">
        <span class="d-none d-lg-block">NiceAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- End Icons Navigation -->

  </header><!-- End Header -->

 
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Projects Link -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('projects.index') ? '' : 'collapsed' }}" href="{{ route('projects.index') }}">
                <i class="bi bi-grid"></i>
                <span>Projects</span>
            </a>
        </li>

        <!-- Tasks Link -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('tasks.index') ? '' : 'collapsed' }}" href="{{ route('tasks.index') }}">
                <i class="bx bx-task"></i>
                <span>Tasks</span>
            </a>
        </li>

        <!-- Time Entry Link -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('time-entries.index') ? '' : 'collapsed' }}" href="{{ route('time-entries.index') }}">
                <i class="bi bi-file-earmark"></i>
                <span>Time Entry</span>
            </a>
        </li>

        <!-- Project Report Link -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('report_view.index') ? '' : 'collapsed' }}" href="{{ route('report_view.index') }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Project Report</span>
            </a>
        </li>

    </ul>
</aside>



  <main id="main" class="main">
    {{ $slot }}
  </main><!-- End Main Content -->

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const projectFilter = document.getElementById('projectFilter');
        const projectReportTable = $('#projectReportTable');

        const dataTable = projectReportTable.DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "ajax": function (data, callback, settings) {
                const projectId = projectFilter.value;
                const length = data.length; // Get the length from DataTables request
                const start = data.start;  // Get the start value from DataTables request

                // Build the URL with query parameters
                const url = new URL('/projects/report', window.location.origin);
                if (projectId) {
                    url.searchParams.append('project_id', projectId);
                }
                url.searchParams.append('length', length);
                url.searchParams.append('start', start);

                // Fetch data from the server
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        callback({
                            draw: settings.iDraw,
                            recordsTotal: data.recordsTotal,
                            recordsFiltered: data.recordsFiltered,
                            data: data.data
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching report data:', error);
                    });
            },
            "columns": [
                { "data": "index" },
                { "data": "name" },
                { "data": "total_hours" }
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if (rowData.style) {
                            $(td).attr('style', rowData.style);
                        }
                    }
                },
                {
                    "targets": [1],
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if (rowData.style) {
                            $(td).attr('style', rowData.style);
                        }
                    }
                },
                {
                    "targets": [2],
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if (rowData.style) {
                            $(td).attr('style', rowData.style);
                        }
                    }
                }
            ]
        });

        projectFilter.addEventListener('change', function () {
            dataTable.ajax.reload(); // Reload the DataTable with the new filter
        });
    });


</script>
<script>

    document.getElementById('project_id').addEventListener('change', function () {
            const projectId = this.value;
            const taskSelect = document.getElementById('task_id');
            taskSelect.innerHTML = '<option value="">Loading...</option>';

            fetch(`/tasks/get/${projectId}`)
                .then(response => response.json())
                .then(data => {
                    taskSelect.innerHTML = '<option value="">Select Task</option>';
                    data.tasks.forEach(task => {
                        taskSelect.innerHTML += `<option value="${task.id}">${task.name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching tasks:', error));
        });


    document.getElementById('addTimeEntryForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('/time-entry/store', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reset the form
                document.getElementById('addTimeEntryForm').reset();

                // Close the modal
                const addTimeEntryModal = bootstrap.Modal.getInstance(document.getElementById('addTimeEntryModal'));
                if (addTimeEntryModal) {
                    addTimeEntryModal.hide();
                }

                // Show a success alert
                alert('Time entry added successfully!');
                
                // Refresh DataTable or dynamically add new entry (if needed)
                $('#timeEntriesTable').DataTable().ajax.reload(); // This will reload the DataTable
            } else if (data.errors) {
                // Clear any existing error messages
                const errorContainer = document.getElementById('errorContainer');
                errorContainer.innerHTML = ''; // Clear previous errors

                // Loop through each error and display it
                for (const [field, messages] of Object.entries(data.errors)) {
                    messages.forEach(message => {
                        // Append error messages with the 'alert alert-danger' class
                        errorContainer.innerHTML += `
                            <div class="alert alert-danger">${message}</div>
                        `;
                    });
                }
            } else {
                alert('Failed to add time entry');
            }
        })
        .catch(error => console.error('Error adding time entry:', error));
    });

    $(document).ready(function() {
        // Initialize the DataTable
        $('#timeEntriesTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,             
            ordering: false,            
            lengthChange: false,         
            pageLength: 10,
            ajax: {
                url: '/time-entries',
                type: 'GET',
                dataSrc: function (json) {
                    return json.data; 
                }
            },
            columns: [
                { data: 'SNo' },          
                { data: 'project_name' },  
                { data: 'task_name' },      
                { data: 'hours' },          
                { data: 'date' },           
                { data: 'description' }     
            ]
        });
    
    });
</script>


</body>

</html>
