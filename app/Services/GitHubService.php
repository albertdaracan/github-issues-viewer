<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * GitHubService
 *
 * This service class handles all communication with the GitHub REST API.
 * It centralizes API calls, headers, token usage, and error handling.
 *
 * Purpose:
 * - Fetch all open issues assigned to the authenticated user
 * - Fetch specific issue details
 * - Provide consistent and professional API error handling
 */
class GitHubService
{
    // Stores the user's GitHub Personal Access Token (PAT)
    protected string $token;

    public function __construct()
    {
        // Load the GitHub token from environment variables
        $this->token = env('GITHUB_PERSONAL_TOKEN');
    }

    /**
     * Returns all required HTTP headers for GitHub API requests.
     *
     * Required headers:
     * - Authorization: authenticates the user via token
     * - User-Agent: GitHub requires this header for all API calls
     * - Accept: tells GitHub to return JSON in API v3 format
     */
    protected function headers(): array
    {
        return [
            'Authorization' => "token {$this->token}",
            'User-Agent'    => 'LaravelApp',
            'Accept'        => 'application/vnd.github.v3+json',
        ];
    }

    /**
     * Fetch all OPEN issues assigned to the authenticated user.
     *
     * Uses the endpoint: GET https://api.github.com/issues
     *
     * Query parameters:
     * - filter = assigned → only issues assigned to the token owner
     * - state = open → exclude closed issues
     * - per_page = 100 → retrieve up to 100 issues
     *
     * @return array
     * @throws \Exception on API error
     */
    public function getAssignedOpenIssues(): array
    {
        $response = Http::withHeaders($this->headers())
            ->get('https://api.github.com/issues', [
                'filter'   => 'assigned',
                'state'    => 'open',
                'per_page' => 100,
            ]);

        // Pass response into our centralized error handler
        return $this->handleResponse($response);
    }

    /**
     * Fetch detailed information about a specific issue in a repository.
     *
     * Example API endpoint:
     * GET https://api.github.com/repos/{owner}/{repo}/issues/{issue}
     *
     * @param string $owner GitHub username or org
     * @param string $repo Repository name
     * @param int    $issue Issue number
     * @return array|null
     * @throws \Exception on API error
     */
    public function getIssueDetails(string $owner, string $repo, int $issue): ?array
    {
        $response = Http::withHeaders($this->headers())
            ->get("https://api.github.com/repos/{$owner}/{$repo}/issues/{$issue}");

        $result = $this->handleResponse($response);

        return $result ?: null;
    }

    public function updateIssues()
    {
        // $response = Http::withHeaders($this->headers())
        //     ->update("https://api.github.com/repos/{$owner}/{$repo}/issues/{$issue}");

        // $result = $this->handleResponse($response);

        // return $result ?: null;

    }

    /**
     * Centralized API response handler.
     *
     * Purpose:
     * - Simplify controller logic (controllers no longer check status codes)
     * - Provide clear and meaningful error messages
     * - Ensure all GitHub API failures are handled consistently
     *
     * @throws \Exception
     */
    protected function handleResponse($response): array
    {
        // If HTTP request succeeded (status 200-299)
        if ($response->successful()) {
            return $response->json();
        }

        // Provide custom error messages for common GitHub API responses
        switch ($response->status()) {
            case 401:
                throw new \Exception('Unauthorized: Invalid or expired GitHub token.');
            case 403:
                throw new \Exception('Forbidden: Token is missing required permissions. (Use repo scope for private repos)');
            case 404:
                throw new \Exception('Not found: The repo or issue does not exist, or you lack access.');
            case 429:
                throw new \Exception('Rate limit exceeded: GitHub API limit reached. Try again later.');
            default:
                throw new \Exception('GitHub API error: HTTP ' . $response->status());
        }
    }
}
