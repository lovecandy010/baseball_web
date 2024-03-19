<?php
session_start();
require_once './includes/config.php';


// Make sure the form is being submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $team1Player1 = $_POST["team1Player1"];
    $team1Player2 = $_POST["team1Player2"];
    $team1Player3 = $_POST["team1Player3"];
    $team1Player4 = $_POST["team1Player4"];
    $team1Player5 = $_POST["team1Player5"];
    $team1Player6 = $_POST["team1Player6"];
    $team1Player7 = $_POST["team1Player7"];
    $team1Player8 = $_POST["team1Player8"];
    $team1Player9 = $_POST["team1Player9"];
    $team1PlayerP = $_POST["team1PlayerP"];
    $team2Player1 = $_POST["team2Player1"];
    $team2Player2 = $_POST["team2Player2"];
    $team2Player3 = $_POST["team2Player3"];
    $team2Player4 = $_POST["team2Player4"];
    $team2Player5 = $_POST["team2Player5"];
    $team2Player6 = $_POST["team2Player6"];
    $team2Player7 = $_POST["team2Player7"];
    $team2Player8 = $_POST["team2Player8"];
    $team2Player9 = $_POST["team2Player9"];
    $team2PlayerP = $_POST["team2PlayerP"];

    $winningPitcher = $_POST["winningPitcher"];
    $losingPitcher = $_POST["losingPitcher"];
    $save = $_POST["save"];
    $finalHit = $_POST["finalHit"];

    $gameComment1 = $_POST["gameComment1"];

    $gameProgress = $_POST["gameProgress"];
    $stadium = $_POST["stadium"];
    $startTime = $_POST["startTime"];
    $gameResult = $_POST["gameResult"];
    $gameScore = $_POST["gameScore"];

    // Get the date from the form data
    $year = $_POST["year"];
    $month = $_POST["month"];
    $date = $_POST["date"];
    $user_id = $_SESSION['user_id'];
}
    // SQL to insert the form data into the database
$sql = "INSERT INTO write1 (team1Player1, team1Player2, team1Player3, team1Player4, team1Player5, team1Player6, team1Player7, team1Player8, team1Player9, team1PlayerP, team2Player1, 
                team2Player2, team2Player3, team2Player4, team2Player5, team2Player6, team2Player7, team2Player8, team2Player9, team2PlayerP, winningPitcher, losingPitcher, save, finalHit, 
                gameComment1, gameProgress, stadium, startTime, gameResult, gameScore, year, month, date, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        team1Player1 = VALUES(team1Player1), 
        team1Player2 = VALUES(team1Player2), 
        team1Player3 = VALUES(team1Player3), 
        team1Player4 = VALUES(team1Player4), 
        team1Player5 = VALUES(team1Player5), 
        team1Player6 = VALUES(team1Player6), 
        team1Player7 = VALUES(team1Player7), 
        team1Player8 = VALUES(team1Player8), 
        team1Player9 = VALUES(team1Player9), 
        team1PlayerP = VALUES(team1PlayerP), 
        team2Player1 = VALUES(team2Player1), 
        team2Player2 = VALUES(team2Player2), 
        team2Player3 = VALUES(team2Player3), 
        team2Player4 = VALUES(team2Player4), 
        team2Player5 = VALUES(team2Player5), 
        team2Player6 = VALUES(team2Player6), 
        team2Player7 = VALUES(team2Player7), 
        team2Player8 = VALUES(team2Player8), 
        team2Player9 = VALUES(team2Player9), 
        team2PlayerP = VALUES(team2PlayerP), 
        winningPitcher = VALUES(winningPitcher), 
        losingPitcher = VALUES(losingPitcher), 
        save = VALUES(save), 
        finalHit = VALUES(finalHit), 
        gameComment1 = VALUES(gameComment1), 
        gameProgress = VALUES(gameProgress), 
        stadium = VALUES(stadium), 
        startTime = VALUES(startTime), 
        gameResult = VALUES(gameResult), 
        gameScore = VALUES(gameScore)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssssssssssssssssssssiiii", $team1Player1, $team1Player2, $team1Player3, $team1Player4, $team1Player5, $team1Player6, $team1Player7, $team1Player8, $team1Player9, $team1PlayerP, $team2Player1, $team2Player2, $team2Player3, $team2Player4, $team2Player5, $team2Player6, $team2Player7, $team2Player8, $team2Player9, $team2PlayerP, $winningPitcher, $losingPitcher, $save, $finalHit, $gameComment1, $gameProgress, $stadium, $startTime, $gameResult, $gameScore, $year, $month, $date, $user_id);


$result = $stmt->execute();

    if($result){
        echo "정보가 성공적으로 저장되었습니다";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
?>
