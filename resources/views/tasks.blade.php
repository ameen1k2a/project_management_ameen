<x-layout>
    <div class="pagetitle">
        <h1>Manage Tasks</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Tasks</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Tasks Table -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Full Task List</h5>

                        <!-- Table with Bootstrap styling -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Project Name</th>
                                    <th>Task Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $index => $task)
                                    <tr>
                                        <td>{{ $tasks->firstItem() + $index }}</td>
                                        <td>{{ $task->project->name }}</td> <!-- Display Project Name -->
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Bootstrap Pagination -->
                        <div class="pagination">
                            {{ $tasks->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tasks Table -->
        </div>
    </section>
</x-layout>
