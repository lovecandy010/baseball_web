<?php include_once './includes/header.php'; ?>
<?php include_once './includes/sidebar.php'; ?>
<?php include_once './includes/config.php'; ?>

<style>
    @media(min-width:768px){
        .create-group-container{
            padding-left: 200px;
        }
    }
    @media(min-width:960px) {
        .create-group-container select{
            width: 443px;
        }
    }


</style>

<main>
    <div class="create-group-container" style="max-width=500px">
        <div style="display=flex;justify-content:center">
        <img src="images/Vector.png" style="display flex;float:left;padding-right:20px;padding-top:40px"></img>
        <h2 style="font-size:40px;padding-top:40px">SETTING</h2>
        </div>
        <br>
        <br>
        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users where id=$user_id";

        // SQL 쿼리 실행
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <form action="formationForm.php" method="POST">
                    <p>Nickname <input type="text" name="nickname" placeholder="Nickname" value="<?= $row['nickname']; ?>" style="float:right"></p><br>
                    
                    <p>E-mail<input type="email" name="email" placeholder="Email" value="<?= $row['email']; ?>" style="float:right"></p><br>
                    
                    <p>password<input type="password" id="password" name="password"  value="<?= $row['password']; ?>" placeholder="Password" style="float:right"></p><br>
                    
                    <p>Confirm <br>Password<input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" style="float:right"></p><br>
                    
                    <p>Team<select name="team" style="float:right"></p>
                        <option value="키움" <?php echo $row['team'] == '키움' ? 'selected':''; ?>>키움 히어로즈</option>
                        <option value="두산" <?php echo $row['team'] == '두산' ? 'selected':''; ?>>두산 베어스</option>
                        <option value="롯데" <?php echo $row['team'] == '롯데' ? 'selected':''; ?>>롯데 자이언츠</option>
                        <option value="삼성" <?php echo $row['team'] == '삼성' ? 'selected':''; ?>>삼성 라이온즈</option>
                        <option value="한화" <?php echo $row['team'] == '한화' ? 'selected':''; ?>>한화 이글스</option>
                        <option value="KIA" <?php echo $row['team'] == 'KIA' ? 'selected':''; ?>>KIA 타이거즈</option>
                        <option value="LG" <?php echo $row['team'] == 'LG' ? 'selected':''; ?>>LG 트윈스</option>
                        <option value="SSG" <?php echo $row['team'] == 'SSG' ? 'selected':''; ?>>SSG 랜더스</option>
                        <option value="NC" <?php echo $row['team'] == 'NC' ? 'selected':''; ?>>NC 다이노스</option>
                        <option value="KT" <?php echo $row['team'] == 'KT' ? 'selected':''; ?>>KT 위즈</option>
                    </select>
                    <button type="submit">SAVE</button>
                </form>
                <?php
            }
        }
        ?>
    </div>
</main>

<?php include_once './includes/footer.php'; ?>
