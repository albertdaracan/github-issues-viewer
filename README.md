📄 README.md — GitHub Issues Viewer (Laravel 11 + PHP)
📌 Overview

This Laravel application allows a GitHub user to:

View all open issues assigned to them across all repositories

Open a detailed view of a specific issue

Navigate easily between issue list and detail view

See friendly error messages when authentication fails, permissions are missing, or GitHub API errors occur

This project was built as part of the GFP Take-Home Coding Test.

🛠 Installation & Setup
1. Clone the repository
git clone https://github.com/albertdaracan/github-issues-viewer.git
cd github-issues-viewer

2. Install dependencies
composer install

3. Create your .env file
cp .env.example .env

4. Generate the application key
php artisan key:generate

🔧 Configure Your Environment (.env Setup)

Open your .env file and add your GitHub token:

GITHUB_PERSONAL_TOKEN=your_github_token_here


This token is required to authenticate your calls to GitHub’s REST API.

🔐 How to Generate Your GitHub Personal Access Token

Go to:
https://github.com/settings/tokens

Click Generate new token (classic)

Set:

Note: GitHub Issues Viewer

Expiration: 30 days

Select only this scope:

repo


This gives the app read access to both public and private issues assigned to you.

Click Generate Token

Copy the token and paste it into your .env:

GITHUB_PERSONAL_TOKEN=ghp_xxxxxxxxxxxxxxxxxx

⚠ Important:

Do NOT commit your .env file

.env is already in .gitignore

▶ Running the Application

Start the server:

php artisan serve


Then open:

http://localhost:8000


You should now see the list of issues assigned to your GitHub account.

🧪 Testing the App
How to create an issue assigned to yourself

Go to any GitHub repository you own

Click Issues → New Issue

Fill in the title & description

On the right side, under Assignees, click:
Assign yourself

Save the issue

Your Laravel app will now display it under "Assigned Open Issues".

📚 Features
✔ Assigned Issues List

Displays:

Issue number

Title

Created date

Repository name

✔ Detailed Issue View

Shows:

Issue number

Title

Description (body)

Created timestamp

✔ Error Handling

Shows friendly messages when:

Token is missing or invalid

GitHub API is rate-limited

Private repo access is not allowed

GitHub returns 404 / 403 / 500 etc.

✔ Clean Architecture

Service layer (GitHubService) handles all API calls

Controller only handles request/response

Views are simple and readable

📁 Project Structure
app/
 ├── Http/
 │     └── Controllers/
 │           └── IssueController.php
 └── Services/
        └── GitHubService.php

resources/
 └── views/
        └── issues/
             ├── index.blade.php
             └── show.blade.php

✔ Coding Test Requirements Checklist
Requirement	Status
List open issues assigned to the user	✔ Completed
Do not show closed issues	✔ Completed
Show issue number, title, created at	✔ Completed
Open issue detail page	✔ Completed
Show title, number, created at, body	✔ Completed
Back navigation	✔ Completed
Use GITHUB_PERSONAL_TOKEN	✔ Completed
Error handling	✔ Completed
Clean architecture	✔ Completed
🧰 Technologies Used

Laravel 11

PHP 8+

GitHub REST API v3

Laravel HTTP Client

Bootstrap (CDN)

📬 Notes for Reviewers

The .env file is not included in the repository for security reasons

Follow the instructions above to generate your own GitHub token

The app supports both private and public repo issues

Code includes comments and clear separation of concerns

🙌 Author

Your Name
GitHub: https://github.com/your-username

Email: your-email@example.com

If you want, I can:

✨ Add screenshots
✨ Add project architecture diagram
✨ Improve formatting
✨ Insert badges (build status, version, etc.)

Just let me know!