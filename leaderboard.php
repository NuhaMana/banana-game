<?php
session_start();
include "php/db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="page-wrap">
    <h1 style="color:white; margin-bottom:20px;">🏆 Leaderboard</h1>
    <table>
        <tr>
            <th>Rank</th>
            <th>Player</th>
            <th>Score</th>
            <th>Played At</th>
        </tr>

        <?php
        $sql = "SELECT users.username, MAX(scores.score) AS best_score, MAX(scores.played_at) AS played_at
                FROM scores
                JOIN users ON scores.user_id = users.id
                GROUP BY users.id
                ORDER BY best_score DESC
                LIMIT 10";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $rank = 1;
            while ($row = $result->fetch_assoc()) {
                $class = "";
                if ($rank == 1) $class = "gold";
                elseif ($rank == 2) $class = "silver";
                elseif ($rank == 3) $class = "bronze";

                echo "<tr class='$class'>";
                echo "<td>$rank</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . $row['best_score'] . "</td>";
                echo "<td>" . $row['played_at'] . "</td>";
                echo "</tr>";

                $rank++;
            }
        } else {
            echo "<tr><td colspan='4'>No scores yet</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <br>
    <a href="dashboard.php" class="top-btn">Back to Dashboard</a>
</div>
</body>
</html>