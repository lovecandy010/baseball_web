<?php
session_start();
require_once './includes/config.php';

if(isset($_POST['watchedGame'])) {
    $watched_game = 1;
} else {
    $watched_game = 0;
}
$weather = $_POST['weather'];
$mood = $_POST['mood'];
$extra_input_data = $_POST['extraInputData'];
$game_comment = $_POST['gameComment2'];
$year = $_POST['year'];
$month = $_POST['month'];
$date = $_POST['date'];
$user_id = $_SESSION['user_id'];

$uploaded_files = [];
if(isset($_FILES['uploadedFiles'])){
    for ($i = 0; $i < count($_FILES['uploadedFiles']['name']); $i++) {
        $file_path = 'uploads/' . $_FILES['uploadedFiles']['name'][$i];
        move_uploaded_file($_FILES['uploadedFiles']['tmp_name'][$i], $file_path);
        $uploaded_files[] = $file_path;
    }
}
$uploaded_files_json = json_encode($uploaded_files);


$sql = "INSERT INTO write2 (year, month, date, user_id, watched_game, weather, mood, extra_input_data, game_comment, uploaded_files) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
        watched_game = VALUES(watched_game), 
        weather = VALUES(weather), 
        mood = VALUES(mood), 
        extra_input_data = VALUES(extra_input_data), 
        game_comment = VALUES(game_comment), 
        uploaded_files = VALUES(uploaded_files)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiisssssss", $year, $month, $date, $user_id, $watched_game, $weather, $mood, $extra_input_data, $game_comment, $uploaded_files_json);

$result = $stmt->execute();

if ($result) {
    $response = ['success' => true, 'message' => 'Data has been inserted successfully.'];
} else {
    $response = ['success' => false, 'message' => 'Failed to insert data.'];
}

header('Content-Type: application/json');
echo json_encode($response);
$stmt->close();
$conn->close();
