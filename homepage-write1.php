<?php include_once './includes/header.php'; ?>
<?php include_once './includes/sidebar.php'; ?>
<?php require_once './includes/config.php'; ?>
<?php
        $year = $_GET['year'];
        $month = $_GET['month'];
        $date = $_GET['date'];  
?>

<style>
    body {
        font-family: 'Black Han Sans', sans-serif;
    }

    .lineup-container {
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin: 20px 0;
    }
    table {
        border-collapse: collapse;
        width: 25%;
    }
    th, td {
        border: 1px solid #000;
        padding: 0px;
        text-align: center;
        background-color: #fff;
    }
    .stadium-image {
        text-align: center;
        width: 25%;
    }
    .game-info {
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin: 20px 0;
    }
    .game-comment {
        width: 100%;
        margin: 20px 0;
    }
    #submitBtn2 {
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #submitBtn2:hover {
        background-color: #0056b3;
    }

    /*여기부터는 글자 관련 */
    #team1-lineup tr{
        border:5px solid;
    }

    #team2-lineup tr{
        border:5px solid;
    }

    #team1-lineup input{
        font-family: 'Malgun Gothic', sans-serif;
    }

    #team2-lineup input{
        font-family: 'Malgun Gothic', sans-serif;
    }

    .game-info input, select{
        font-family: 'Black Han Sans', sans-serif;
    }

    #gameComment1, #gameComment2{
        font-family: 'Malgun Gothic', sans-serif;
    }

    textarea{
        border:3px solid;
    }

    #gameForm2 input{
        border:5px solid;
        font-family: 'Malgun Gothic', sans-serif;
    }

    @media(max-width:768px) {
        .stadium-image-upload{
            display:none;
        }

        #addExtraInputBtn{
            width: 40px !important;
            height: 40px;
            padding: 0px;
        }

        .stadium-image-upload2 img{
            width:90vw;
        }

        .lineup-container table{
            width:35vw;
        }
    }

    /*웹부분 */
    @media(min-width:768px){
        br{
            display: none !important;
        }

        .stadium-image-upload2{
            display:none;
            margin:0 auto;
            padding: 0px;
        }

        #gameForm2 label{
            padding-bottom: 20px;
            font-size:40px;

        }

        .watched-game-toggle-btn{
            padding:0px !important;
        }
     
        .create-group-container{
            padding-left: 200px;
        }

        .game-progress{
            width: 100%;
            padding:0;
            display:flex;
            justify-content: space-between;
        }
        .game-progress label{
            font-size:30px;
            padding: 0;
        }

        .game-progress input{
            margin:0 auto;
            width:10px;
        }
    }

</style>

<main>
    <div class="create-group-container">
        <div class="header-container" style="font-size: 30px;">
            <h2><?= $year.'-'.$month.'-'.$date; ?></h2>
            <div class="toggle-btn-container">
                <label class="toggle-btn">
                    <input type="checkbox" id="toggleInput" onchange="togglePages()">
                    <span class="toggle-slider">
                <span class="toggle-label toggle-label-1">1</span>
                <span class="toggle-label toggle-label-2">2</span>
            </span>
                </label>
            </div>
        </div>


        <?php
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM write1 WHERE year = '$year' AND month = '$month' AND date = '$date' AND user_id = '$user_id'";

        // SQL 쿼리 실행
        $result = mysqli_query($conn, $sql);
        // 결과가 있는 경우 결과를 출력해주는 예시 코드
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <form id="gameForm" action="write_game1.php" style="display: none; flex-direction: column; align-items: center;">
            <!-- 경기 진행 결과 -->
            <div class="game-progress" style="width: 80%;">
                <label for="gameProgress1" class="radio-label" style="">
                    <input type="radio" id="gameProgress1" name="gameProgress" value="진행" style="" required <?= $row['gameProgress']== '진행' ? 'checked':''; ?>> 진행
                </label>
                <label for="gameProgress2" class="radio-label">
                    <input type="radio" id="gameProgress2" name="gameProgress" value="콜드" style="" required <?= $row['gameProgress']== '콜드' ? 'checked':''; ?>> 콜드
                </label>
                <label for="gameProgress3" class="radio-label">
                    <input type="radio" id="gameProgress3" name="gameProgress" value="취소" style="" required <?= $row['gameProgress']== '취소' ? 'checked':''; ?>> 취소
                </label>
            </div>


            <!-- 경기 정보 -->
            <div class="game-info" style="display: flex; justify-content: space-around; width: 100%;">
                <input type="text" id="stadium" name="stadium" placeholder="경기장" required value="<?= $row['stadium']; ?>" style="border-radius:20px;text-align:center;border:4px solid;">
                <input type="text" id="startTime" name="startTime" placeholder="경기시작시간" required value="<?= $row['startTime']; ?>" style="border-radius:20px;text-align:center;border:4px solid;">
                <select id="gameResult" name="gameResult" required style="border-radius:20px;text-align:center;border:4px solid;">
                    <option value="승" <?= $row['gameResult']== '승' ? 'selected':''; ?>>승</option>
                    <option value="무" <?= $row['gameResult']== '무' ? 'selected':''; ?>>무</option>
                    <option value="패" <?= $row['gameResult']== '패' ? 'selected':''; ?>>패</option>
                </select>
                <input type="text" id="gameScore" name="gameScore" placeholder="경기 스코어 (00:00)" required value="<?= $row['gameScore']; ?>" style="border-radius:20px;background-color:#000;color:#fff;text-align:center;">
            </div>

            <!-- 야구장 이미지 업로드 (데이터 저장 된 경우)-->
            <div class="stadium-image-upload2">
                <img src="./images/LINEUP.png" alt="">
            </div>

            <!-- 라인업 입력 -->
            <div class="lineup-container" style="display: flex; justify-content: space-around; width: 100%;">
                <table id="team1-lineup" style="border:5px solid;">
                    <tr>
                        <th>AWAY</th>
                    </tr>
                    <!-- 1번부터 9번까지 입력란 추가 -->
                    <tr>
                        <td>1. <input type="text" name="team1Player1" value="<?= $row['team1Player1']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>2. <input type="text" name="team1Player2" value="<?= $row['team1Player2']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>3. <input type="text" name="team1Player3" value="<?= $row['team1Player3']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>4. <input type="text" name="team1Player4" value="<?= $row['team1Player4']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>5. <input type="text" name="team1Player5" value="<?= $row['team1Player5']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>6. <input type="text" name="team1Player6" value="<?= $row['team1Player6']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>7. <input type="text" name="team1Player7" value="<?= $row['team1Player7']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>8. <input type="text" name="team1Player8" value="<?= $row['team1Player8']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>9. <input type="text" name="team1Player9" value="<?= $row['team1Player9']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>P. <input type="text" name="team1PlayerP" value="<?= $row['team1PlayerP']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                </table>

                <!-- 야구장 이미지 업로드 (데이터 저장 된 경우)-->
                <div class="stadium-image-upload" style="padding : 20px;">
                    <img src="./images/LINEUP.png" alt="">
                </div>

                <table id="team2-lineup" style="border : solid 5px;">
                    <tr>
                        <th>HOME</th>
                    </tr>
                    <!-- 1번부터 9번까지 입력란 추가 -->
                    <tr>
                        <td>1. <input type="text" name="team2Player1" value="<?= $row['team2Player1']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>2. <input type="text" name="team2Player2" value="<?= $row['team2Player2']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>3. <input type="text" name="team2Player3" value="<?= $row['team2Player3']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>4. <input type="text" name="team2Player4" value="<?= $row['team2Player4']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>5. <input type="text" name="team2Player5" value="<?= $row['team2Player5']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>6. <input type="text" name="team2Player6" value="<?= $row['team2Player6']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>7. <input type="text" name="team2Player7" value="<?= $row['team2Player7']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>8. <input type="text" name="team2Player8" value="<?= $row['team2Player8']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>9. <input type="text" name="team2Player9" value="<?= $row['team2Player9']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                    <tr>
                        <td>P. <input type="text" name="team2PlayerP" value="<?= $row['team2PlayerP']; ?>" required style="border:0 solid black;margin:0 auto;"></td>
                    </tr>
                </table>
            </div>

            <!-- 승리투수, 패전투수, 세이브, 결승타 입력 -->
            <div class="game-info" style="display: flex; justify-content: space-around; width: 100%;">
                <input type="text" id="winningPitcher" name="winningPitcher" value="<?= $row['winningPitcher']; ?>" placeholder="승리투수" required style="border-radius:20px;text-align:center;border:3px solid;">
                <input type="text" id="losingPitcher" name="losingPitcher" value="<?= $row['losingPitcher']; ?>" placeholder="패전투수" required style="border-radius:20px;text-align:center;border:3px solid;">
                <input type="text" id="save" name="save" placeholder="세이브" value="<?= $row['save']; ?>" required style="border-radius:20px;text-align:center;border:3px solid;">
                <input type="text" id="finalHit" name="finalHit" value="<?= $row['finalHit']; ?>" placeholder="결승타" required style="border-radius:20px;border-color:red;color:red;text-align:center;border:3px solid;">
            </div>

            <!-- 경기 코멘트 입력 -->
            <div style="border-radius:10px;border:5px solid #000; font-size:20px;width:140px;height:25px;text-align:center;float:left;">경기 코멘트</div>

            <textarea id="gameComment1" name="gameComment1" rows="4" required placeholder="경기 코멘트를 입력하세요"><?= $row['gameComment1']; ?></textarea>

            <!-- Submit Button -->
            <button id="submitBtn1" type="submit">작성 완료</button>
        </form>

        <?php  }
        } else {
            ?>
            <form id="gameForm" action="write_game1.php" style="display: none; flex-direction: column; align-items: center;">
                <!-- 경기 진행 결과 -->
                <div class="game-progress" style="width: 80%;">
                    <label for="gameProgress1" class="radio-label">
                        <input type="radio" id="gameProgress1" name="gameProgress" value="진행" style="" required> 진행
                    </label>
                    <label for="gameProgress2" class="radio-label">
                        <input type="radio" id="gameProgress2" name="gameProgress" value="콜드" style="" required> 콜드
                    </label>
                    <label for="gameProgress3" class="radio-label">
                        <input type="radio" id="gameProgress3" name="gameProgress" value="취소" style="" required> 취소
                    </label>
                </div>


                <!-- 경기 정보 -->
                <div class="game-info" style="display: flex; justify-content: space-around; width: 100%;">
                    <input type="text" id="stadium" name="stadium" placeholder="경기장" required style="border-radius:20px;text-align:center;border:5px solid;">
                    <input type="text" id="startTime" name="startTime" placeholder="경기시작시간" required style="border-radius:20px;text-align:center;border:5px solid;">
                    <select id="gameResult" name="gameResult" required style="border-radius:20px;text-align:center;border:5px solid;">
                        <option value="승">승</option>
                        <option value="무">무</option>
                        <option value="패">패</option>
                    </select>
                    <input type="text" id="gameScore" name="gameScore" placeholder="경기 스코어 (00:00)" required style="border-radius:20px;background-color:#000;color:#fff;text-align:center;">
                </div>

                <!-- 야구장 이미지 업로드 (데이터 저장안된경우) -->
                <div class="stadium-image-upload2" style="padding : 20px;">
                    <img src="./images/LINEUP.png" alt="" style="">
                </div>


                <!-- 라인업 입력 -->
                <div class="lineup-container" style="display: flex; justify-content: space-around; width: 100%;">
                    <table id="team1-lineup" style="border : solid 5px;">
                        <tr>
                            <th>AWAY</th>
                        </tr>
                        <!-- 1번부터 9번까지 입력란 추가 -->
                        <tr>
                            <td>1. <input type="text" name="team1Player1" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>2. <input type="text" name="team1Player2" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>3. <input type="text" name="team1Player3" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>4. <input type="text" name="team1Player4" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>5. <input type="text" name="team1Player5" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>6. <input type="text" name="team1Player6" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>7. <input type="text" name="team1Player7" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>8. <input type="text" name="team1Player8" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>9. <input type="text" name="team1Player9" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>P. <input type="text" name="team1PlayerP" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                    </table>

                    <!-- 야구장 이미지 업로드 (데이터 저장안된경우) -->
                    <div class="stadium-image-upload" style="padding : 20px;">
                        <img src="./images/LINEUP.png" alt="" style="">
                    </div>

                    <table id="team2-lineup" style="border : solid 5px;">
                        <tr>
                            <th>HOME</th>
                        </tr>
                        <!-- 1번부터 9번까지 입력란 추가 -->
                        <tr>
                            <td>1. <input type="text" name="team2Player1" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>2. <input type="text" name="team2Player2" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>3. <input type="text" name="team2Player3" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>4. <input type="text" name="team2Player4" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>5. <input type="text" name="team2Player5" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>6. <input type="text" name="team2Player6" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>7. <input type="text" name="team2Player7" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>8. <input type="text" name="team2Player8" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>9. <input type="text" name="team2Player9" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                        <tr>
                            <td>P. <input type="text" name="team2PlayerP" required style="border:0 solid black;margin:0 auto;"></td>
                        </tr>
                    </table>
                </div>

                <!-- 승리투수, 패전투수, 세이브, 결승타 입력 -->
                <div class="game-info" style="display: flex; justify-content: space-around; width: 100%;">
                    <input type="text" id="winningPitcher" name="winningPitcher" placeholder="승리투수" required style="border-radius:20px;text-align:center;border:3px solid;">
                    <input type="text" id="losingPitcher" name="losingPitcher" placeholder="패전투수" required style="border-radius:20px;text-align:center;border:3px solid;">
                    <input type="text" id="save" name="save" placeholder="세이브" required style="border-radius:20px;text-align:center;border:3px solid;">
                    <input type="text" id="finalHit" name="finalHit" placeholder="결승타" required style="border-radius:20px;border-color:red;color:red;text-align:center;border:3px solid;">
                </div>

                <!-- 경기 코멘트 입력 -->
                <div style="border-radius:10px;border:3px solid #000; font-size:20px;width:140px;height:25px;text-align:center;float:left;border:5px solid;">경기 코멘트</div>

                <textarea id="gameComment1" name="gameComment1" rows="4" required placeholder="경기 코멘트를 입력하세요"></textarea>

                <!-- Submit Button -->
                <button id="submitBtn1" type="submit">작성 완료</button>
            </form>
        <?php
        }
        ?>



        <?php

        $sql = "SELECT * FROM write2 WHERE year = '$year' AND month = '$month' AND date = '$date' AND user_id = '$user_id'";

        // SQL 쿼리 실행
        $result = mysqli_query($conn, $sql);
        // 결과가 있는 경우 결과를 출력해주는 예시 코드
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>

                <form id="gameForm2" action="write_game2.php" method="POST" style="display: block;">
                    <label for="watchedGame">직관 유무</label>
                    <div class="watched-game-toggle-container">
                        <label class="watched-game-toggle-btn">
                            <input type="checkbox" id="watchedGame" name="watchedGame" value="<?= $row['watched_game'] == 1 ? 'yes':'no' ?>" onchange="updateWatchedGameValue()">
                            <span class="watched-game-toggle-slider">
                            </span>
                        </label>

                        <script>
                            <?php if ($row['watched_game'] == 1) { ?>
                            $(document).ready(function() {
                                $('#watchedGame').prop('checked', true);
                                $('#watchedGame').change();
                            });
                            <?php } ?>
                        </script>
                    </div>

                    <label for="weather">날씨</label>
                    <input type="text" id="weather" name="weather" required placeholder="날씨를 입력하세요" value="<?= $row['weather']; ?>">

                    <label for="mood">기분</label>
                    <input type="text" id="mood" name="mood" required placeholder="기분을 입력하세요"  value="<?= $row['mood']; ?>">

                    <input type="hidden" id="extraInputCount" name="extraInputCount" value="0">




                    <div id="extraInputs">
                        <?php
                        $extraInputData = json_decode($row['extra_input_data'], true);
                        $count = count($extraInputData);
                        ?>
                        <?php
                        for ($i = 1; $i <= $count; $i++) {
                            ?>
                            <div class="extra-input-container">
                                <label for="extraInfo<?=$i?>"><?=$extraInputData['newExtraInfo'.$i]['label']?></label>
                                <input type="text" id="newExtraInfo<?=$i?>" name="newExtraInfo<?=$i?>" required=""  value="<?= $extraInputData['newExtraInfo'.$i]['value']?>">
                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" id="extraInputData" name="extraInputData" value="<?= $count ?>">

                    <label for="newExtraInfoLabel"></label><br>
                    <input type="text" id="newExtraInfoLabel" name="newExtraInfoLabel" placeholder="추가하실 정보를 입력하세요">
                    <button type="button" id="addExtraInputBtn" >추가</button><br>


                    <label for="gameComment2">경기 코멘트</label>
                    <textarea id="gameComment2" name="gameComment2" rows="4" required placeholder="경기 코멘트를 입력하세요"><?= $row['game_comment'] ?></textarea>

                    <div class="image-slider">
                        <button type="button" id="prevBtn" class="slider-btn"><</button>
                        <div id="carouselImages">
                            <!-- 이미지는 여기에 추가됩니다. -->
                        </div>
                        <button type="button" id="nextBtn" class="slider-btn">></button>
                    </div>
                    <input type="file" id="fileUpload" name="fileUpload" multiple style="display: none;">
                    <button type="button" id="addImageBtn" class="add-image-btn">이미지 추가</button>

                    <div class="video-container">
                        <input type="file" id="videoUpload" name="videoUpload" style="display: none;">
                        <!-- 동영상은 여기에 추가됩니다. -->
                    </div>
                    <button type="button" id="addVideoBtn" class="add-video-btn">동영상 추가</button>

                    <button id="submitBtn2" type="submit" style="margin-top: 30px;">작성 완료</button>
                </form>
        <?php
            }
        } else {
            ?>
            <form id="gameForm2" action="write_game2.php" method="POST" style="display: block;">
                <label for="watchedGame">직관 유무</label>
                <div class="watched-game-toggle-container">
                    <label class="watched-game-toggle-btn">
                        <input type="checkbox" id="watchedGame" name="watchedGame" value="no" onchange="updateWatchedGameValue()">
                        <span class="watched-game-toggle-slider">
        </span>
                    </label>
                </div>

                <label for="weather">날씨</label>
                <input type="text" id="weather" name="weather" required placeholder="날씨를 입력하세요">

                <label for="mood">기분</label>
                <input type="text" id="mood" name="mood" required placeholder="기분을 입력하세요">

                <input type="hidden" id="extraInputCount" name="extraInputCount" value="0">

                <div id="extraInputs"></div>
                <input type="hidden" id="extraInputData" name="extraInputData">

                <label for="newExtraInfoLabel"></label><br>
                <input type="text" id="newExtraInfoLabel" name="newExtraInfoLabel" placeholder="추가하실 정보를 입력하세요">
                <button type="button" id="addExtraInputBtn">추가</button><br>


                <label for="gameComment2">경기 코멘트</label>
                <textarea id="gameComment2" name="gameComment2" rows="4" required placeholder="경기 코멘트를 입력하세요"></textarea>

                <div class="image-slider">
                    <button type="button" id="prevBtn" class="slider-btn"><</button>
                    <div id="carouselImages">
                        <!-- 이미지는 여기에 추가됩니다. -->
                    </div>
                    <button type="button" id="nextBtn" class="slider-btn">></button>
                </div>
                <input type="file" id="fileUpload" name="fileUpload" multiple style="display: none;">
                <button type="button" id="addImageBtn" class="add-image-btn">이미지 추가</button>

                <div class="video-container">
                    <input type="file" id="videoUpload" name="videoUpload" style="display: none;">
                    <!-- 동영상은 여기에 추가됩니다. -->
                </div>
                <button type="button" id="addVideoBtn" class="add-video-btn">동영상 추가</button>

                <button id="submitBtn2" type="submit" style="margin-top: 30px;">작성 완료</button>
            </form>
        <?php
        }
        ?>



    </div>
</main>


<script src="./js/write-toggle.js"></script>
<?php
$sql = "SELECT * FROM write2 WHERE year = '$year' AND month = '$month' AND date = '$date' AND user_id = '$user_id'";

// SQL 쿼리 실행
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $extraInputData = json_decode($row['extra_input_data'], true);
        $count = count($extraInputData);
    ?>
    <script>
        getExtraInput(<?= $count+1 ?>, <?= $row['extra_input_data']; ?>);
        getFile(<?= $row['uploaded_files'] ?>);
    </script>
    <?php
    }
}
?>
<?php include_once './includes/footer.php'; ?>
