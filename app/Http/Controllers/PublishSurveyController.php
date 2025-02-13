<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use App\Models\SurveyResult;
use App\Models\SurveySchema;
use Illuminate\Http\Request;
use App\Models\DigitalPlatform;
use App\Models\PublishedSurvey;

class PublishSurveyController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Survey', 'url' => route('publish-surveys.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $status = $request->get('status');
        $publishSurveys = PublishedSurvey::query();

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $publishSurveys->where('title', 'like', '%' . $search . '%');
        }

        // Apply status filter if it's not "Status" (default option)
        if ($status && $status !== 'Status') {
            $publishSurveys->where('status', $status);
        }

        $publishSurveys = $publishSurveys->paginate($perPage)->appends(['search' => $search, 'status' => $status, 'per_page' => $perPage]);                

        return view('auth.publish-surveys.index', compact('publishSurveys', 'breadcrumbs', 'perPage', 'search', 'status'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Survey', 'url' => route('publish-surveys.index'), 'active' => false],
            ['label' => 'Select Schema', 'url' => route('publish-surveys.create'), 'active' => true],
        ];

        return view('auth.publish-surveys.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $userId = auth('web')->id();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $team = Team::create([
            'name' => $validated['title'],
            'description' => $validated['description'],
        ]);

        $team->users()->attach($userId, [
            'role' => 'Author', 
            'start_date' => now(),
        ]);       

        $survey = PublishedSurvey::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'execution_team_id' => $team->id,
            'status' => 'Draft',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Publish survey details created!', 
            'details' => $survey->title,
            'redirect' => route('publish-surveys.selectSchema', ['publish_survey' => $survey->id]),
        ], 201);  
    }

    public function show(PublishedSurvey $publishedSurvey)
    {
        $publishedSurvey->load([   
            'schema',            // Load the associated survey schema
            'team.users',        // Load team and team members
            'digitalPlatform',   // Load digital platform
            'service'            // Load digital service
        ]);
    
        return response()->json([
            'id' => $publishedSurvey->id,
            'title' => $publishedSurvey->title,
            'survey_link' => $publishedSurvey->survey_link,
            'status' => $publishedSurvey->status,
            'start_date' => $publishedSurvey->start_date,
            'end_date' => $publishedSurvey->end_date,
            'survey_schema' => $publishedSurvey->schema->title ?? 'N/A',
            'team_name' => $publishedSurvey->team->name ?? 'N/A',
            'team_members' => $publishedSurvey->team->users->pluck('name')->toArray() ?? [],
            'digital_platform' => $publishedSurvey->digitalPlatform->platform_name ?? 'N/A',
            'service' => $publishedSurvey->service->service_name ?? 'N/A'
        ]);
    }    

    public function edit(PublishedSurvey $publish_survey)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Surveys', 'url' => route('publish-surveys.index'), 'active' => false],
            ['label' => 'Update Survey', 'url' => route('publish-surveys.edit', $publish_survey->id), 'active' => true],
        ]; 

        return view('auth.publish-surveys.edit',compact('publish_survey', 'breadcrumbs'));
    }

    public function update(Request $request, PublishedSurvey $publish_survey)
    {
        $validated = $request->validate([
            'title' => ['required','string', 'max:255'],
            'description' => ['nullable' ,'string'],
        ]);

        $publish_survey->update([
            'title' => $validated['title'], 
            'description' => $validated['description'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Publish survey details updated!', 
            'details' => $publish_survey->title,
            'redirect' => route('publish-surveys.selectSchema', $publish_survey->id),
        ], 200);          
    }

    public function destroy(PublishedSurvey $publish_survey)
    {
        $team = $publish_survey->team;
    
        if ($team) {
            $team->users()->detach();
            $team->delete();
        }
        $publish_survey->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Survey and associated team deleted successfully!',
        ], 200);
    }
    
    public function selectSchema(Request $request, PublishedSurvey $publish_survey)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Survey', 'url' => route('publish-surveys.index'), 'active' => false],
            ['label' => 'Select Schema', 'url' => route('publish-surveys.create'), 'active' => true],
        ];
    
        $perPage = (int) $request->get('per_page', 10);
        $search = $request->get('search', null);
    
        // Fetch only schemas with status "Available"
        $schemas = SurveySchema::where('status', 'Available');
    
        if (!empty($search)) {
            $schemas->where('name', 'like', '%' . $search . '%');
        }
    
        $schemas = $schemas->paginate($perPage)->appends($request->only(['search', 'per_page']));
    
        // Pass schema_id to the view
        return view('auth.publish-surveys.select-schema', compact(
            'publish_survey',
            'schemas',
            'breadcrumbs',
            'perPage',
            'search'
        ));
    }

    public function storeSchema(Request $request, PublishedSurvey $publish_survey)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:survey_schemas,id',
            'title' => 'required|string|max:255',
        ]);
    
        try {
            // Update the schema_id in the PublishedSurvey
            $publish_survey->update(['schema_id' => $validated['id']]);
    
            return response()->json([
                'success' => true,
                'message' => 'Schema assigned successfully!',
                'redirect' => route('publish-surveys.selectApp', $publish_survey->id),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while assigning the schema.',
            ], 500);
        }
    }    

    public function selectApp(Request $request, PublishedSurvey $publish_survey)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Survey', 'url' => route('publish-surveys.index'), 'active' => false],
            ['label' => 'Select Platform', 'url' => route('publish-surveys.selectApp', $publish_survey->id), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $platforms = DigitalPlatform::query();

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $platforms->where('platform_name', 'like', '%' . $search . '%');
        }

        $platforms = $platforms->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);
    
        return view('auth.publish-surveys.select-app', compact(
            'publish_survey', 
            'platforms', 
            'breadcrumbs', 
            'perPage', 
            'search'
        ));
    }

    public function storeApp(Request $request, PublishedSurvey $publish_survey)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'title' => 'required|string|max:255',
        ]);

        try {
            // Temporarily store the selected platform ID in the session
            session(['selected_platform_id' => $validated['id']]);
    
            return response()->json([
                'success' => true,
                'message' => 'Platform assigned successfully!',
                'redirect' => route('publish-surveys.selectService', $publish_survey->id),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while assigning the digital platform.',
            ], 500);
        }
    }

    public function selectService(Request $request, PublishedSurvey $publish_survey)
    {
        $selectedPlatformId = session('selected_platform_id');
    
        if (!$selectedPlatformId) {
            return redirect()->route('publish-surveys.selectApp', $publish_survey->id)
                ->with('error', 'Please select a digital platform first.');
        }
    
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Survey', 'url' => route('publish-surveys.index'), 'active' => false],
            ['label' => 'Select Service', 'url' => route('publish-surveys.selectService', $publish_survey->id), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');        

        // Query services related to the selected platform
        $services = Service::whereHas('digitalPlatforms', function ($query) use ($selectedPlatformId) {
            $query->where('digital_platform_id', $selectedPlatformId);
        })->with(['digitalPlatforms' => function ($query) use ($selectedPlatformId) {
            $query->where('digital_platform_id', $selectedPlatformId);
        }]);

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $services->where('service_name', 'like', '%' . $search . '%');
        }

        $services = $services->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);        
    
        return view('auth.publish-surveys.select-service', compact(
            'publish_survey',
            'services',
            'breadcrumbs',
            'perPage',
            'search'          
        ));
    }    
    

    public function storeService(Request $request, PublishedSurvey $publish_survey)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'digitalPlatformServiceId' => 'required|integer',
        ]);
    
        try {
            // Update the published survey with the selected digital platform service ID
            $publish_survey->update([
                'digital_platform_service_id' => $validated['digitalPlatformServiceId'],
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Digital Platform Service ID saved successfully!',
                'redirect' => route('publish-surveys.selectTeam', ['publish_survey' => $publish_survey->id]),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the service details.',
            ], 500);
        }
    }
    
    public function selectTeam(Request $request, PublishedSurvey $publish_survey)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Survey', 'url' => route('publish-surveys.index'), 'active' => false],
            ['label' => 'Select Team', 'url' => route('publish-surveys.selectTeam', ['publish_survey' => $publish_survey->id]), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $team = $publish_survey->team;

        $search = $request->input('search');

        $assignedUsers = $team 
            ? $team->users()->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage])
            : null;

        $allUsers = User::all(); 

        return view('auth.publish-surveys.select-team', compact(
            'publish_survey', 
            'breadcrumbs', 
            'team', 
            'assignedUsers', 
            'allUsers',
            'perPage', 
            'search',
            )
        );        
    }

    public function storeTeamMember(Request $request, PublishedSurvey $publish_survey)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'in:Co-Author,Reviewer'], // Restrict to valid roles
        ]);

        // Fetch or create the team for the survey
        $team = $publish_survey->team ?? Team::create([
            'name' => $publish_survey->name . ' Team',
            'description' => 'Team for survey: ' . $publish_survey->name,
        ]);
        
        $existingMember = $team->users()->wherePivot('user_id', $request->user_id)->exists();

        if ($existingMember) {
            return response()->json([
                'message' => 'User is already a team member.'
            ], 400);
        }        
    
        // Assign the team to the survey schema if not already associated
        if (!$publish_survey->team) {
            $publish_survey->team()->associate($team);
            $publish_survey->save();
        }

        $startDate = $request->start_date ?? now()->toDateString();
        // Attach or update the user's role in the team
        $team->users()->syncWithoutDetaching([
            $request->user_id => [
                'role' => $request->role,
                'start_date' => $startDate,
            ],
        ]);
    
        return response()->json([
            'message' => 'Team member added successfully!',
            'user_id' => $request->user_id,
            'role' => $request->role,
        ], 201);        
    }
    
    public function removeTeamMember(Request $request, PublishedSurvey $publish_survey)
    {
        // Validate the request to ensure the user_id is provided and valid
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);
    
        try {
            // Fetch the team associated with the survey
            $team = $publish_survey->team;
    
            // If the team does not exist, return an error
            if (!$team) {
                return response()->json([
                    'success' => false,
                    'message' => 'Team not found for the selected survey.',
                ], 404);
            }
    
            // Check if the user exists in the team
            $userExists = $team->users()->wherePivot('user_id', $validated['user_id'])->exists();
            if (!$userExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not part of the team.',
                ], 400);
            }
    
            // Detach the user from the team
            $team->users()->detach($validated['user_id']);
    
            return response()->json([
                'success' => true,
                'message' => 'Team member removed successfully!',
                'user_id' => $validated['user_id'],
            ], 200);
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the team member.',
            ], 500);
        }
    }

    public function publish(Request $request, PublishedSurvey $publish_survey)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Survey', 'url' => route('publish-surveys.index'), 'active' => false],
            ['label' => 'Publish', 'url' => route('publish-surveys.publish', ['publish_survey' => $publish_survey->id]), 'active' => true],
        ];
        if (!$publish_survey->survey_link) {     
            $publish_survey->survey_link = url('/surveys/' . $publish_survey->id);
            $publish_survey->save();
        }
        return view('auth.publish-surveys.publish', compact(
            'publish_survey',
            'breadcrumbs',
            )
        );        
    }

    public function storePublishSurvey(Request $request, PublishedSurvey $publish_survey)
    {
        $rules = [
            'status' => ['required', 'in:Published,Closed'],
        ];
    
        if ($request->input('status') === 'Published') {
            $rules['start_date'] = ['required', 'date', 'before_or_equal:end_date'];
            $rules['end_date'] = ['required', 'date', 'after_or_equal:start_date'];
        }
    
        $validated = $request->validate($rules);
    
        try {
            $publish_survey->update([
                'survey_link' => $request->input('survey_link'),
                'status' => $validated['status'],
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Publish survey status saved successfully!',
                // 'redirect' => route('publish-surveys.index', ['publish_survey' => $publish_survey->id]),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the survey status.',
            ], 500);
        }
    }

    public function generateLinks()
    {
        $surveys = PublishedSurvey::all();
        foreach ($surveys as $survey) {
            if (!$survey->survey_link) {
                $survey->survey_link = url('/surveys/' . Str::uuid());
                $survey->save();
            }
        }
        return redirect()->back()->with('success', 'Hyperlinks generated successfully!');
    }

    public function showSurvey(Request $request, $id)
    {
        $survey = PublishedSurvey::with('schema')->findOrFail($id);
    
        if (!$survey->schema || !$survey->schema->schema_json) {
            abort(404, 'Survey schema not found or invalid.');
        }
    
        return view('public.survey-form', [
            'survey' => $survey,
            'surveyData' => json_decode($survey->schema->schema_json, true), // Decode the JSON structure
        ]);
    }

    public function storeSurveyResult(Request $request)
    {
        $validated = $request->validate([
            'published_survey_id' => ['required', 'exists:published_surveys,id'],
            'response_json' => ['required', 'json'],
            'submitted_at' => ['required', 'date'],
        ]);
    
        try {
            $surveyResult = SurveyResult::create([
                'published_survey_id' => $validated['published_survey_id'],
                'response_json' => $validated['response_json'],
                'submitted_at' => $validated['submitted_at'],
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Survey result saved successfully.',
                'data' => $surveyResult,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save survey result.',
            ], 500);
        }
    }       
}
