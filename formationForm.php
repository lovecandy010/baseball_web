<?php
// DB 연결 정보 가져오기
session_start();
require_once './includes/config.php';

// 폼 데이터가 전송되었는지 확인
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼 데이터 추출하기
    $user_id = $_SESSION['user_id'];
    $nickname = $_POST["nickname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $team = $_POST["team"];

    // SQL 쿼리 실행하기
    $sql = "update users set email='$email', nickname='$nickname', password='$password', team='$team' where id=$user_id";

    if (mysqli_query($conn, $sql)) {
        // 회원가입 성공 시
        mysqli_close($conn);
        $_SESSION["user_nickname"] = $nickname;
        $_SESSION["user_team"] = $team;
        echo "<script>alert('회원정보가 수정되었습니다');location.href='formation.php';</script>";
        exit();
    } else {
        // 회원가입 실패 시
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
