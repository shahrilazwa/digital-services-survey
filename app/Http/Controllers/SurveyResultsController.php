<?php

namespace App\Http\Controllers;

use App\Models\SurveyResult;
use Illuminate\Http\Request;
use App\Models\PublishedSurvey;

class SurveyResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Survey Results', 'url' => route('survey-results.index'), 'active' => true],
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
        
        // Attach completed survey count to each published survey
        foreach ($publishSurveys as $survey) {
            $survey->completed_surveys = SurveyResult::countCompletedSurveys($survey->id);
        }        

        return view('auth.survey-results.index', compact('publishSurveys', 'breadcrumbs', 'perPage', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $breadcrumbs = [
        //     ['label' => 'Home', 'url' => route('dashboard'), 'active' => false],
        //     ['label' => 'Publish Surveys', 'url' => route('publish-surveys.index'), 'active' => false],
        //     ['label' => 'Survey Results', 'url' => route('survey-results.view', $id), 'active' => true],
        // ];

        // $surveyResults = SurveyResult::where('published_survey_id', $id)->get();
        // return view('auth.survey-results.show', compact('surveyResults', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function view($id)
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Publish Surveys', 'url' => route('survey-results.index'), 'active' => false],
            ['label' => 'Survey Results', 'url' => route('survey-results.view', $id), 'active' => true],
        ];
    
        // Fetch Published Survey
        $publishedSurvey = PublishedSurvey::with('schema')->where('id', $id)->firstOrFail();
        
        // Fetch associated Survey Schema
        $surveySchema = $publishedSurvey->schema;
    
        // Fetch survey results
        $surveyResults = SurveyResult::where('published_survey_id', $id)->get();
    
        // Decode JSON responses
        $formattedResults = $surveyResults->map(function ($result) {
            return json_decode($result->response_json, true);
        });
    
        return view('auth.survey-results.view', [
            'surveyId' => $id,
            'surveySchema' => $surveySchema,
            'surveyResults' => $formattedResults,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    public function tableView($id)
    {
        $publishedSurvey = PublishedSurvey::with('schema')->where('id', $id)->firstOrFail();
        $surveySchema = $publishedSurvey->schema->schema_json; // ✅ Get Schema JSON
        $surveyResults = SurveyResult::where('published_survey_id', $id)->get();
    
        $formattedResults = $surveyResults->map(function ($result) {
            return json_decode($result->response_json, true);
        });
    
        return view('auth.survey-results.table-view', [
            'surveyId' => $id,
            'surveySchema' => $surveySchema,
            'surveyResults' => $formattedResults,
        ]);
    }      
}
