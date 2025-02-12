<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\SurveySchema;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Log;

class SchemaController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Schema', 'url' => route('schemas.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $status = $request->get('status');
        $schemas = SurveySchema::query();

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $schemas->where('title', 'like', '%' . $search . '%');
        }

        // Apply status filter if it's not "Status" (default option)
        if ($status && $status !== 'Status') {
            $schemas->where('status', $status);
        }        

        $schemas = $schemas->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);                

        return view('auth.schemas.index', compact('schemas', 'breadcrumbs', 'perPage', 'search'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Schema', 'url' => route('schemas.index'), 'active' => false],
            ['label' => 'Create Schema', 'url' => route('schemas.create'), 'active' => true],
        ];
        
        return view('auth.schemas.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $userId = auth('web')->id();

        $request->validate([
            'title' => ['required','string', 'max:255'],
            'description' => ['nullable' ,'string'],
            'completed_steps' => 'nullable|string'
        ]);        

        $team = Team::create([
            'name' => $request->title,
            'description' => $request->description,
        ]);

        $team->users()->attach($userId, [
            'role' => 'Author', 
            'start_date' => now(),
        ]);

        $schemaJson = [
            'title' => $request->title,
            'description' => $request->description,
            'logoPosition' => 'right',
        ];      

        $surveySchema = SurveySchema::create([
            'team_id' => $team->id,
            'title' => $request->title,
            'description' => $request->description,
            'schema_json' => json_encode($schemaJson),
            'completed_steps' => [],
            'created_by' => $userId,
        ]);
        
        $completedSteps = $surveySchema->completed_steps ?? [];
        if ($request->has('completed_steps') && !in_array($request->completed_steps, $completedSteps)) {
            $completedSteps[] = $request->completed_steps;
        }
        
        $surveySchema->update(['completed_steps' => $completedSteps]);

        ActivityLogger::log('Created', 'SurveySchema', $surveySchema->id, [
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Schema created!', 
            'details' => $request->title,
            'id' => $surveySchema->id,
            'completed_steps' => $surveySchema->completed_steps,
        ], 201);        
    }

    public function show(SurveySchema $schema)
    {
        $schema->load([   
            'team.users',
        ]);

        return response()->json([
            'id' => $schema->id,
            'title' => $schema->title,
            'status' => $schema->status,
            'created_at' => $schema->created_at,
            'modified_at' => $schema->end_date,
            'team_name' => $schema->team->name ?? 'N/A',
            'team_members' => $schema->team->users->pluck('name')->toArray() ?? [],
        ]);        
    }

    public function edit(SurveySchema $schema)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Schema', 'url' => route('schemas.index'), 'active' => false],
            ['label' => 'Update Schema', 'url' => route('schemas.create'), 'active' => true],
        ]; 

        return view('auth.schemas.edit',compact('schema', 'breadcrumbs'));
    }

    public function update(Request $request, SurveySchema $schema)
    {
        $userId = auth('web')->id();

        $request->validate([
            'title' => ['required','string', 'max:255'],
            'description' => ['nullable' ,'string'],
        ]);      

        $schema->update([
            'title' => $request->title, 
            'description' => $request->description
        ]);     

        ActivityLogger::log('Updated', 'SurveySchema', $schema->id, [
            'title' => 'Update Schema Details',
            'description' => 'Changes made to schema details',
        ]); 

        return response()->json([
            'success' => true,
            'message' => 'Schema updated!', 
            'details' => $request->title,
            'id' => $schema->id,
        ], 201); 
    }

    public function destroy(string $schemaId)
    {
        try {
            // Find the survey by ID
            $schema = SurveySchema::findOrFail($schemaId);
    
            // Delete team members from the pivot table (user_team_roles)
            if ($schema->team) {
                $schema->team->users()->detach(); // Detach all users from the team
            }
    
            // Delete the team itself
            $schema->team()->delete();
    
            // Delete survey questions (if related via pivot table)
            $schema->questions()->detach();
    
            // Delete the survey
            $schema->delete();

            ActivityLogger::log('Deleted', 'SurveySchema', $schema->id, [
                'title' => $schema->title,
                'description' => $schema->description,
            ]);            
    
            return redirect()->route('schemas.index')->with('success', 'Schema and its associated records deleted successfully.');
        } catch (Exception $e) {
            // Log the detailed error
            Log::error('Schema delete failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'schema_id' => $schema->id
            ]);

            return redirect()->route('schemas.index')->with('error', 'Failed to delete schema and its associated records.');
        }
    }
    

    public function createSchema(SurveySchema $schema)
    {   
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Schema', 'url' => route('schemas.index'), 'active' => false],
            ['label' => 'Design Schema', 'url' => route('schemas.create'), 'active' => true],
        ];

        return view('auth.schemas.design', compact('schema', 'breadcrumbs'));
    }
    
    public function showCreator(SurveySchema $schema)
    {
        // Ensure the survey schema exists and is accessible
        if (!$schema) {
            abort(404, 'Survey schema not found.');
        }
    
        return view('auth.schemas.creator', compact('schema'));
    }    
    
    public function storeSchema(Request $request, SurveySchema $schema)
    {
        // Validate the incoming request
        $request->validate([
            'schema_data' => 'required|json',
        ]);
    
        // Decode the incoming schema_data
        $newSchemaData = json_decode($request->input('schema_data'), true);
        if (is_null($newSchemaData)) {
            return response()->json(['error' => 'Invalid schema data format'], 422);
        }
    
        try {
            // Decode the existing schema JSON (if any)
            $existingSchemaData = $schema->schema_json ? json_decode($schema->schema_json, true) : [];
    
            if (is_null($existingSchemaData)) {
                $existingSchemaData = [];
            }
    
            // Merge existing schema JSON with the new data
            $mergedSchemaData = array_merge($existingSchemaData, $newSchemaData);
    
            // Check if the schema has pages before marking "Schema Design" as completed
            $hasPages = isset($mergedSchemaData['pages']) && is_array($mergedSchemaData['pages']) && !empty($mergedSchemaData['pages']);
    
            // Update completed_steps only if pages exist
            $completedSteps = $schema->completed_steps ?? []; // Ensure completed_steps is an array
            if ($hasPages && !in_array('Schema Design', $completedSteps)) {
                $completedSteps[] = 'Schema Design';
            }
    
            // Update the schema model
            $schema->update([
                'schema_json' => json_encode($mergedSchemaData), // Save the merged JSON
                'completed_steps' => $completedSteps, // Save updated steps
                'current_step' => 'Schema Design', // Set the current step
            ]);
    
            // Log activity
            ActivityLogger::log('Updated', 'SurveySchema', $schema->id, [
                'title' => $schema->title,
                'description' => $schema->description,
            ]);
    
            // Return a successful response
            return response()->json([
                'status' => 'success',
                'message' => 'Survey Schema Updated!',
                'details' => $schema->title,
                'id' => $schema->id,
                'completed_steps' => $completedSteps,
            ], 200);
    
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Schema design update failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'schema_id' => $schema->id ?? null,
            ]);
    
            // Return a generic error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update survey schema.',
            ], 500);
        }
    }    
    
    public function createTeam(Request $request, SurveySchema $schema)
    {   
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Schema', 'url' => route('schemas.index'), 'active' => false],
            ['label' => 'Design Schema', 'url' => route('schemas.create'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $team = $schema->team;

        // Get search query from request
        $search = $request->input('search');

        // Filter assigned users based on the search term
        $assignedUsers = $team 
            ? $team->users()->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage])
            : null;

        $allUsers = User::all(); 

        return view('auth.schemas.team', compact(
            'schema',
            'breadcrumbs',
            'team',
            'assignedUsers',
            'allUsers',
            'perPage', 
            'search',
            )
        );
    }

    public function storeTeamMember(Request $request, SurveySchema $schema)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'in:Co-Author,Reviewer'], 
            'current_step' => ['nullable', 'in:Schema Details,Schema Design,Schema Team,Preview Survey'],
        ]);
    
        $team = $schema->team ?? Team::create([
            'name' => $schema->name . ' Team',
            'description' => 'Team for survey: ' . $schema->name,
        ]);
    
        $schema->team()->associate($team);
        $schema->save();
    
        $team->users()->syncWithoutDetaching([
            $request->user_id => [
                'role' => $request->role,
                'start_date' => now(),
            ],
        ]);
    
        // Step update logic
        $completedSteps = $schema->completed_steps ?? [];
        if (!in_array($request->current_step, $completedSteps)) {
            $completedSteps[] = $request->current_step;
            $schema->update([
                'completed_steps' => $completedSteps,
                'current_step' => $request->current_step,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Team member added successfully!',
        ]);
    }
    

    public function removeTeamMember(Request $request, SurveySchema $schema)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'current_step' => ['nullable', 'in:Schema Details,Schema Design,Schema Team,Preview Survey'],
        ]);
    
        $team = $schema->team;
    
        if ($team) {
            $team->users()->detach($request->user_id);
        }
    
        // Step update logic
        $completedSteps = $schema->completed_steps ?? [];
        if (!in_array($request->current_step, $completedSteps)) {
            $completedSteps[] = $request->current_step;
            $schema->update([
                'completed_steps' => $completedSteps, // Pass the array directly
                'current_step' => $request->current_step,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Team member removed successfully!',
        ]);
    }    

    public function updateTeam(Request $request, SurveySchema $schema)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'team_desc' => 'nullable|string|max:255',
            'current_step' => ['nullable', 'in:Schema Details,Schema Design,Schema Team,Preview Survey'],
        ]);
    
        $team = $schema->team;
    
        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }
    
        $team->update([
            'name' => $request->input('team_name'),
            'description' => $request->input('team_desc'),
        ]);
    
        // Handle step completion logic
        $completedSteps = $schema->completed_steps ?? [];
        if ($request->filled('current_step') && !in_array($request->current_step, $completedSteps)) {
            $completedSteps[] = $request->current_step;
            $schema->update([
                'completed_steps' => $completedSteps, // No need for json_encode
                'current_step' => $request->current_step,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Team details updated successfully!',
        ]);
    }
    
    public function previewSchema(SurveySchema $schema)
    {   
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Schema', 'url' => route('schemas.index'), 'active' => false],
            ['label' => 'Preview Schema', 'url' => route('schemas.create'), 'active' => true],
        ];

        if (!$schema->schema_json || !json_decode($schema->schema_json, true)) {
            return redirect()->back()->with('error', 'Invalid survey schema.');
        }
    
        return view('auth.schemas.preview', compact('schema', 'breadcrumbs'));
    }
    
    public function getSurveyData(SurveySchema $schema)
    {
        if (!$schema->schema_json) {
            return response()->json(['error' => 'Survey schema not found.'], 404);
        }
    
        return response()->json(json_decode($schema->schema_json, true));
    }

    public function updateStep(Request $request, SurveySchema $schema)
    {
        $request->validate([
            'current_step' => ['required', 'in:Schema Details,Schema Design,Schema Team,Schema Preview,Schema Manage'],
        ]);
    
        $completedSteps = $schema->getCompletedSteps();
    
        // Add the step if not already completed
        if (!in_array($request->current_step, $completedSteps)) {
            $completedSteps[] = $request->current_step;
            $schema->update([
                'completed_steps' => $completedSteps,
                'current_step' => $request->current_step,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Step updated successfully!',
            'completed_steps' => $completedSteps,
        ]);
    }

    public function manageSchema($schemaId)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Schema', 'url' => route('schemas.index'), 'active' => false],
            ['label' => 'Preview Schema', 'url' => route('schemas.create'), 'active' => true],
        ];

        $schema = SurveySchema::findOrFail($schemaId);
        $statusOptions = SurveySchema::STATUS;
    
        return view('auth.schemas.manage', compact('schema', 'breadcrumbs', 'statusOptions'));
    }
    
    public function updateStatus(Request $request, $schemaId)
    {
        $schema = SurveySchema::findOrFail($schemaId);
        $request->validate([
            'status' => 'required|string|in:' . implode(',', array_keys(SurveySchema::STATUS)),
        ]);
    
        $schema->status = $request->status;
        $completedSteps = $schema->getCompletedSteps();

        if (!in_array('Schema Manage', $completedSteps)) {
            $completedSteps[] = 'Schema Manage';
        }

        $schema->update([
            'status' => $request->status,
            'completed_steps' => $completedSteps, 
            'current_step' => 'Schema Manage',
        ]);
    
        return redirect()->route('schemas.index')->with('success', 'Schema status updated successfully.');
    }    
}