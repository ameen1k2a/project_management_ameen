<x-layout>
    <div class="pagetitle">
        <h1>Time Entries</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
                <li class="breadcrumb-item active">Time Entries</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Time Entries Table -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Time Entries</h5>
                        
                        <!-- Add Time Entry Button -->
                        <div class="mb-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTimeEntryModal">
                                Add Time Entry
                            </button>
                        </div>
                        
                        <!-- Table with Bootstrap styling -->
                        <table id="timeEntriesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Project Name</th>
                                    <th>Task Name</th>
                                    <th>Hours</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody id="timeEntriesTableBody">
                                <!-- Data will be filled by DataTables -->
                            </tbody>
                        </table>

                        
                    </div>
                </div>
            </div>
            <!-- End Time Entries Table -->
        </div>
    </section>

    <!-- Add Time Entry Modal -->
    <div class="modal fade" id="addTimeEntryModal" tabindex="-1" aria-labelledby="addTimeEntryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addTimeEntryForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTimeEntryModalLabel">Add Time Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                    
                        <!-- Error Container -->
                        <div id="errorContainer"></div>
                    
                        <div class="form-group mb-3">
                            <label for="project_id">Project</label>
                            <select class="form-control" id="project_id" name="project_id" required>
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="task_id">Task</label>
                            <select class="form-control" id="task_id" name="task_id" required>
                                <option value="">Select Task</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="hours">Hours</label>
                            <input type="number" class="form-control" id="hours" name="hours" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="entry_date">Date</label>
                            <input type="date" class="form-control" id="entry_date" name="entry_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Time Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Time Entry Modal -->
</x-layout>


