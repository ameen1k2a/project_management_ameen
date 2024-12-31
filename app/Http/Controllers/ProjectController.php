<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TimeEntry;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class ProjectController extends Controller
{
    // Display all projects with pagination
    public function index()
    {
        $projects = Project::paginate(10);
        return view('projects', compact('projects'));
    }

    // Display full list of tasks (no need for a specific project)
    public function tasks()
    {
        $tasks = Task::with('project')->paginate(10);  // Eager load 'project' to show project name
        return view('tasks', compact('tasks'));
    }


    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',  // Ensure task exists
            'hours' => 'required|numeric|min:0',      // Ensure hours is numeric and greater than or equal to 0
            'entry_date' => 'required|date',          // Ensure the date is a valid date
            'description' => 'nullable|string|max:255', // Optional description, with max length
        ]);

        // Store the time entry
        $timeEntry = TimeEntry::create([
            'task_id' => $request->task_id,
            'hours' => $request->hours,
            'date' => $request->entry_date,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'data' => $timeEntry]);
    }


    public function timeEntries(Request $request)
    {
        if ($request->ajax()) {
            // Get current page and items per page from the request
            $page = $request->get('start', 0) / $request->get('length', 10) + 1; // Page number (starts from 1)
            $perPage = $request->get('length', 10); // Items per page (default 10)
    
            // Eager load task and project relationships, and paginate
            $timeEntries = TimeEntry::with(['task', 'task.project'])
                ->paginate($perPage, ['*'], 'page', $page); // Paginate with dynamic per page and current page
    
            // Format the data for DataTable
            $data = $timeEntries->map(function ($entry) {
                return [
                    'SNo' => $entry->id,  // or use other unique identifiers
                    'project_name' => $entry->task->project->name,
                    'task_name' => $entry->task->name,
                    'hours' => $entry->hours,
                    'date' => $entry->date,
                    'description' => $entry->description
                ];
            });
    
            // Return the formatted data along with pagination info
            return response()->json([
                'data' => $data,
                'recordsTotal' => $timeEntries->total(),
                'recordsFiltered' => $timeEntries->total(),  // Assuming no filtering, update if needed
            ]);
        }
    
        $projects = Project::all(); // Fetch all projects for the dropdown in the modal
    
        return view('time_entry', compact('projects'));
    }
    
    


    public function getTasks($projectId)
    {
        $tasks = Task::where('project_id', $projectId)->get(['id', 'name']);
        return response()->json(['tasks' => $tasks]);
    }


    public function report_view(Request $request)
    {
        $projects = Project::all(); 
        return view('report', compact('projects'));
    }
  
    public function report(Request $request)
    {
        // Default length (fallback to 10 if not provided)
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);   
        
        // Query projects that have tasks
        $query = Project::with(['tasks' => function ($query) {
            $query->select('tasks.id', 'tasks.project_id', 'tasks.name')
                ->withSum('timeEntries', 'hours');
        }])->has('tasks');  // Only include projects that have tasks

        // Filter by project_id if provided
        if ($request->has('project_id') && $request->project_id) {
            $query->where('id', $request->project_id);
        }

        // Apply pagination dynamically based on DataTables parameters
        $totalRecords = $query->count(); // Total number of records
        $projects = $query->offset($start)->limit($length)->get(); // Paginated results

        $tableRows = []; // To store the generated table rows

        foreach ($projects as $index => $project) {
            // Add index for numbering
            $project->index = $start + $index + 1;

            // Calculate total hours by summing the hours from the tasks
            $totalHours = $project->tasks->sum('time_entries_sum_hours');
            $project->total_hours = $totalHours;

            // Add the project row (for the first task)
            $tableRows[] = [
                'index' => $project->index,
                'name' => $project->name,
                'total_hours' => $project->total_hours,
                'style' => 'background-color: #e0e0e0;' // Example style for project name
            ];

            // Add task rows under the project row
            foreach ($project->tasks as $task) {
                $tableRows[] = [
                    'index' => '',  // Empty index for task rows
                    'name' => $task->name,   // Task name
                    'total_hours' => $task->time_entries_sum_hours ?? 0,
                    'style' => 'background-color: #f0f0f0;' // Example style for task rows
                ];
            }
        }

        return response()->json([
            'recordsTotal' => $totalRecords,    // Total number of records in the database
            'recordsFiltered' => $totalRecords, // Filtered records count (no additional filters applied here)
            'data' => $tableRows,               // Return the structured data with styles
        ]);
    }





}
