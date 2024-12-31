<x-layout>
    <div class="pagetitle">
        <h1>Projects</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Projects</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Projects Table -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Projects</h5>

                        <!-- Table with Bootstrap styling -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Project Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $index => $project)
                                    <tr>
                                        <td>{{  $projects->firstItem() + $index }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Bootstrap Pagination -->
                        <div class="pagination">
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Projects Table -->
        </div>
    </section>
</x-layout>
