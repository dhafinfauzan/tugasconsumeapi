<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League Standings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <style>
        .standings-table {
            width: 100%;
            border-collapse: collapse;
        }
        .standings-table th, .standings-table td {
            text-align: left;
            padding: 8px;
        }
        .standings-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .team-badge {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>League Standings</h1>
        <?php
        $APIkey = '7baac78d40e2a82d0b2898cc1087d26ff2224da804079dd2f9e6ffa929b302c0'; // Replace this with your API Key
        $league_id = 152; // Premier League ID

        $curl_options = array(
          CURLOPT_URL => "https://apiv3.apifootball.com/?action=get_standings&league_id=$league_id&APIkey=$APIkey",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HEADER => false,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_CONNECTTIMEOUT => 5
        );

        $curl = curl_init();
        curl_setopt_array($curl, $curl_options);
        $result = curl_exec($curl);
        curl_close($curl);

        $standings = json_decode($result, true);

        if (!empty($standings)) {
            echo "<table class='standings-table'>";
            echo "<thead><tr><th>Position</th><th>Team</th><th>Points</th><th>Badge</th></tr></thead>";
            echo "<tbody>";
            foreach ($standings as $team) {
                echo "<tr>";
                echo "<td>{$team['overall_league_position']}</td>";
                echo "<td>{$team['team_name']}</td>";
                echo "<td>{$team['overall_league_PTS']}</td>";
                echo "<td><img class='team-badge' src='{$team['team_badge']}' alt='{$team['team_name']} badge'></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "Failed to retrieve standings.";
        }
        ?>
    </main>
</body>
</html>
