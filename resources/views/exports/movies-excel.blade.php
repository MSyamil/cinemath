<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            text-align: left;
            font-size: 10pt;
        }
        th {
            background-color: #1f2937;
            color: #ffffff;
            font-weight: bold;
        }
        .title-row {
            background-color: #E50914;
            color: #ffffff;
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            border: 1px solid #b91c1c;
        }
        .section-header {
            background-color: #e5e7eb;
            color: #111827;
            font-size: 12pt;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #d1d5db;
        }
        .meta-label {
            font-weight: bold;
            background-color: #f3f4f6;
            width: 200px;
        }
        .matrix-header {
            background-color: #374151;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        .matrix-cell {
            text-align: center;
        }
        .formula-cell {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f9fafb;
            color: #047857;
            font-size: 9pt;
        }
        .highlight-cell {
            background-color: #ecfdf5;
            font-weight: bold;
            color: #065f46;
        }
        .number-cell {
            text-align: right;
        }
    </style>
</head>
<body>

    <!-- REPORT TITLE -->
    <table>
        <tr>
            <td colspan="8" class="title-row">
                CINEMATCH MOVIE RECOMMENDATION REPORT
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-style: italic; color: #666666; font-size: 10pt; border-bottom: 2px solid #E50914;">
                AHP (Analytic Hierarchy Process) & SAW (Simple Additive Weighting) Decision Matrix
            </td>
        </tr>
    </table>

    <!-- METADATA & INPUTS -->
    <table>
        <tr>
            <td colspan="4" class="section-header">REPORT METADATA</td>
        </tr>
        <tr>
            <td class="meta-label">Generated At</td>
            <td>{{ $generated_at }}</td>
            <td class="meta-label">Selected Genre</td>
            <td>{{ $selected_genre_name }}</td>
        </tr>
        <tr>
            <td class="meta-label">Watched Filter</td>
            <td>
                @if($watched_filter === 'watched')
                    Sudah Ditonton
                @elseif($watched_filter === 'unwatched')
                    Belum Ditonton
                @else
                    Semua Film (Tanpa Filter)
                @endif
            </td>
            <td class="meta-label">Slider Input Value</td>
            <td>{{ $comparison_value }} (Range: 1 - 9)</td>
        </tr>
        <tr>
            <td class="meta-label">Slider Meaning</td>
            <td colspan="3">
                @if($comparison_value == 5)
                    Seimbang antara Critics Quality (Rating) & Global Hype (Popularity)
                @elseif($comparison_value > 5)
                    Lebih condong ke Global Hype (Popularity) dengan tingkat kepentingan relatif = {{ round($ahp_value, 2) }}x
                @else
                    Lebih condong ke Critics Quality (Rating) dengan tingkat kepentingan relatif = {{ round(1 / $ahp_value, 2) }}x
                @endif
            </td>
        </tr>
    </table>

    <!-- SECTION 1: AHP -->
    <table>
        <tr>
            <td colspan="4" class="section-header">1. ANALYTIC HIERARCHY PROCESS (AHP) - CRITERIA WEIGHTS</td>
        </tr>
        <tr>
            <td colspan="4" style="font-style: italic; font-size: 9.5pt; color: #4b5563; padding: 8px;">
                Membangun matriks perbandingan berpasangan (pairwise comparison matrix) untuk kriteria Rating Kualitas (C1) dan Kriteria Popularitas (C2).
            </td>
        </tr>
    </table>

    <!-- AHP Pairwise Comparison Matrix -->
    <table>
        <thead>
            <tr>
                <th class="matrix-header">Criteria (Pairwise Matrix)</th>
                <th class="matrix-header">Critics Quality (Rating)</th>
                <th class="matrix-header">Global Hype (Popularity)</th>
                <th class="matrix-header">Explanation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold; background-color: #f9fafb;">Critics Quality (Rating)</td>
                <td class="matrix-cell">1.00</td>
                <td class="matrix-cell">{{ round(1 / $ahp_value, 4) }}</td>
                <td>Rating dibanding Rating = 1. Rating dibanding Popularity = 1 / AHP_Value</td>
            </tr>
            <tr>
                <td style="font-weight: bold; background-color: #f9fafb;">Global Hype (Popularity)</td>
                <td class="matrix-cell">{{ round($ahp_value, 4) }}</td>
                <td class="matrix-cell">1.00</td>
                <td>Popularity dibanding Rating = AHP_Value. Popularity dibanding Popularity = 1</td>
            </tr>
            <tr style="font-weight: bold; background-color: #f3f4f6;">
                <td>Total Kolom (Sum)</td>
                <td class="matrix-cell">{{ round(1 + $ahp_value, 4) }}</td>
                <td class="matrix-cell">{{ round((1 / $ahp_value) + 1, 4) }}</td>
                <td>Jumlah nilai per kolom untuk normalisasi</td>
            </tr>
        </tbody>
    </table>

    <!-- AHP Weight Results -->
    <table>
        <thead>
            <tr>
                <th class="matrix-header">Criteria (Normalization)</th>
                <th class="matrix-header">Critics Quality (Rating)</th>
                <th class="matrix-header">Global Hype (Popularity)</th>
                <th class="matrix-header highlight-cell">Priority Vector (Weight)</th>
                <th class="matrix-header">Weight %</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold; background-color: #f9fafb;">Critics Quality (Rating)</td>
                <td class="matrix-cell">{{ round((1 / (1 + $ahp_value)), 4) }}</td>
                <td class="matrix-cell">{{ round(((1 / $ahp_value) / ((1 / $ahp_value) + 1)), 4) }}</td>
                <td class="matrix-cell highlight-cell">{{ round($w_rating, 4) }}</td>
                <td class="matrix-cell highlight-cell">{{ round($w_rating * 100, 2) }}%</td>
            </tr>
            <tr>
                <td style="font-weight: bold; background-color: #f9fafb;">Global Hype (Popularity)</td>
                <td class="matrix-cell">{{ round(($ahp_value / (1 + $ahp_value)), 4) }}</td>
                <td class="matrix-cell">{{ round((1 / ((1 / $ahp_value) + 1)), 4) }}</td>
                <td class="matrix-cell highlight-cell">{{ round($w_popularity, 4) }}</td>
                <td class="matrix-cell highlight-cell">{{ round($w_popularity * 100, 2) }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- SECTION 2: SAW -->
    <table>
        <tr>
            <td colspan="8" class="section-header">2. SIMPLE ADDITIVE WEIGHTING (SAW) - MOVIE ALTERNATIVES SCORING</td>
        </tr>
        <tr>
            <td colspan="8" style="font-style: italic; font-size: 9.5pt; color: #4b5563; padding: 8px;">
                Normalisasi alternatif film berdasarkan nilai maksimum kriteria Benefit. Rating Max (X_max1) = <strong>{{ $max_rating }}</strong>, Popularity Max (X_max2) = <strong>{{ round($max_pop, 2) }}</strong>.<br>
                Rumus Normalisasi: R_ij = X_ij / X_max_j. Rumus Preferensi: V_i = (R_i1 * W_1) + (R_i2 * W_2).
            </td>
        </tr>
    </table>

    <!-- Alternatives Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 50px; text-align: center;">Rank</th>
                <th style="width: 250px;">Movie Title</th>
                <th style="width: 100px; text-align: right;">Original Rating (C1)</th>
                <th style="width: 120px; text-align: right;">Original Popularity (C2)</th>
                <th style="width: 120px; text-align: right;">Normalized Rating (R1)</th>
                <th style="width: 140px; text-align: right;">Normalized Popularity (R2)</th>
                <th style="width: 320px;">SAW Preference Calculation Formula</th>
                <th style="width: 120px; text-align: center;" class="highlight-cell">Match Score</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recommendations as $index => $movie)
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                    <td style="font-weight: 500; color: #111827;">{{ $movie['title'] }}</td>
                    <td class="number-cell">{{ number_format($movie['vote_average'], 1) }}</td>
                    <td class="number-cell">{{ number_format($movie['popularity'], 2) }}</td>
                    <td class="number-cell">{{ number_format($movie['n_rating'], 4) }}</td>
                    <td class="number-cell">{{ number_format($movie['n_pop'], 4) }}</td>
                    <td class="formula-cell">
                        ({{ number_format($movie['n_rating'], 3) }} * {{ number_format($w_rating, 3) }}) + ({{ number_format($movie['n_pop'], 3) }} * {{ number_format($w_popularity, 3) }})
                    </td>
                    <td class="matrix-cell highlight-cell">{{ $movie['match_score'] }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #9ca3af; padding: 20px;">No movies match the selected criteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
