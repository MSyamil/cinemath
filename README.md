# CineMatch 🎬

CineMatch is an intelligent, cinematic movie recommendation web application built with Laravel. It doesn't just show you random movies; it uses advanced decision-making algorithms (AHP & SAW) to find the perfect movie based on your current mood—balancing between **Critics Rating** and **Global Popularity**.

With a stunning, dark-themed glassmorphism UI inspired by modern streaming platforms, CineMatch provides a premium user experience from the moment you open the app.

---

## ✨ Features

*   **Intelligent Recommendations:** Uses the **Analytical Hierarchy Process (AHP)** and **Simple Additive Weighting (SAW)** algorithms to calculate a precise "Match Score" for each movie based on your slider input.
*   **Mood Slider:** A beautifully custom-designed interactive slider that lets you weigh your preference between "Critics Quality" and "Global Hype".
*   **Genre Filtering:** Filter recommendations by your favorite genres instantly.
*   **Authentication System:** Secure user registration and login system.
*   **"Sudah Ditonton" (Watched) Tracking:** Keep track of movies you've already seen with a simple, optimistic UI toggle.
*   **Smart Library Filters:** Hide movies you've already watched to easily discover new content.
*   **Interactive Movie Modals:** Click on any movie card to view a detailed popup containing the high-resolution poster, release year, rating, genre, and synopsis.
*   **Auto-Translated Synopses:** All movie descriptions pulled from the TMDB API are automatically translated to Indonesian using Google Translate on the backend for maximum convenience.
*   **Premium Aesthetic:** Dark cinematic backgrounds, glassmorphism overlays, smooth Alpine.js animations, and "Netflix Red" accents.

## 🛠️ Technology Stack

*   **Backend:** Laravel 11 (PHP)
*   **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
*   **Database:** SQLite / MySQL (Configurable via `.env`)
*   **External API:** TMDB (The Movie Database) API for live movie data.
*   **Packages:** `stichoza/google-translate-php` for seamless text translation.

## 🚀 Installation & Setup

Follow these steps to run the project locally on your machine.

### Prerequisites
*   PHP 8.2 or higher
*   Composer
*   Node.js & npm
*   A TMDB API Key (Get one for free at [themoviedb.org](https://www.themoviedb.org/))

### Steps

1.  **Clone the repository** (if applicable) or download the project files.
2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```
3.  **Install Frontend dependencies:**
    ```bash
    npm install
    ```
4.  **Set up the Environment File:**
    *   Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    *   Open `.env` and add your TMDB API Key:
        ```env
        TMDB_API_KEY=your_api_key_here
        TMDB_BASE_URL=https://api.themoviedb.org/3
        ```
    *   Ensure your database settings are correct (SQLite is used by default in many modern Laravel setups).
5.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```
6.  **Run Migrations:**
    Create the necessary tables (users, watched_movies) in your database:
    ```bash
    php artisan migrate
    ```
7.  **Run the Development Servers:**
    You will need two terminal windows.
    *   Terminal 1 (Backend):
        ```bash
        php artisan serve
        ```
    *   Terminal 2 (Frontend compilation):
        ```bash
        npm run dev
        ```
8.  **Open the App:** Visit `http://localhost:8000` in your browser.

## 🧠 How the Algorithm Works

1.  **User Input:** The user sets a slider value from 1 to 9. 
    *   `1` strongly prefers High Ratings (Critics).
    *   `9` strongly prefers High Popularity (Hype).
    *   `5` is a balanced preference.
2.  **AHP (Analytical Hierarchy Process):** The slider value is converted into a ratio matrix to determine the exact mathematical weights ($W$) for Rating and Popularity.
3.  **API Filtering:** Based on the dominant weight, CineMatch intelligently adjusts the TMDB API query parameters to fetch the most relevant 40 movies.
4.  **SAW (Simple Additive Weighting):** The fetched movies are normalized ($N$). The final `Match Score` is calculated using the formula: `(N_rating * W_rating) + (N_pop * W_popularity)`. The results are then sorted from highest match to lowest and presented to the user.

---
*Built with ❤️ for movie lovers.* 
