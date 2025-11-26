<?php

namespace App\Http\Controllers;

use App\Services\GitHubService;

/**
 * IssueController
 *
 * Purpose:
 * - Display all open issues assigned to the user
 * - Show details of a specific issue
 * - Handle errors gracefully and inform the user
 */
class IssueController extends Controller
{
    protected GitHubService $github;

    /**
     * Use Dependency Injection to inject the GitHubService.
     * This makes the controller clean, testable, and maintainable.
     */
    public function __construct(GitHubService $github)
    {
        $this->github = $github;
    }

    /**
     * Show all open issues assigned to the authenticated GitHub user.
     */
    public function index()
    {
        $issues = [];
        
        try {
            // Fetch issues from the service
            $issues = $this->github->getAssignedOpenIssues();

        } catch (\Exception $e) {
            // Display error message in view
            return view('issues.index', [
                'issues' => $issues,   // ALWAYS send issues variable
                'error' => $e->getMessage()
            ]);
        }

        // Render the issue list with data
        return view('issues.index', compact('issues'));
    }

    /**
     * Show details for a specific issue.
     *
     * @param string $owner Repo owner (username or organization)
     * @param string $repo Repository name
     * @param int $issue Issue number
     */
    public function show($owner, $repo, $issue)
    {
        try {
            // Fetch detailed issue data
            $issueData = $this->github->getIssueDetails($owner, $repo, $issue);
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()
                ->route('issues.index')
                ->with('error', $e->getMessage());
        }

        // If no issue data returned (404 or access denied)
        if (!$issueData) {
            return redirect()
                ->route('issues.index')
                ->with('error', 'Issue not found.');
        }

        // Render the detailed issue view
        return view('issues.show', ['issue' => $issueData]);
    }
}
