<x-layout>
    <div class="pagetitle">
        <h1>Project Report</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Project Report</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Report Filter -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Filter by Project</h5>
                        <!-- Dropdown for project filter -->
                        <select id="projectFilter" class="form-select">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Report Table -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Project Report</h5>

                        <!-- DataTable -->
                        <table id="projectReportTable" class="table ">
                            <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Name</th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include necessary scripts for DataTables -->

</x-layout>
