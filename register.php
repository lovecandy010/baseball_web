<?php include_once './includes/header.php'; ?>


    <main>
    <form action="registerForm.php" method="POST" enctype="multipart/form-data">
        <div class="register-web">
                <div class="form-container">

                <h2 style="font-size:50px;text-align:left;">Sign Up</h2>
                <p style="color:gray;">Welcome to GOAT</p>
                <p style="color:gray;">Please Enter Your Details</p>
                <br>

                <p>Full name</p>
                    <input type="text" name="fullname" placeholder="Full Name">
                    <br>
                    <br>
                <p>Email</p>
                    <input type="email" name="email" placeholder="Email">
                </div>

                <div class="form-container">
                <p>Create your nickname</p>
                    <input type="text" name="nickname" placeholder="Nickname">
                <br>
                <br>
                <form action="registerForm.php" method="POST" enctype="multipart/form-data">
                <p>Create password</p>
                    <input type="password" id="password" name="password" placeholder="Password">
                <br>
                <br>
                <p>confirm password</p>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password">
                <br>
                <p>Team </p>
                    <select name="team">
                        <option value="">Select Team</option>
                        <option value="키움">키움 히어로즈</option>
                        <option value="두산">두산 베어스</option>
                        <option value="롯데">롯데 자이언츠</option>
                        <option value="삼성">삼성 라이온즈</option>
                        <option value="한화">한화 이글스</option>
                        <option value="KIA">KIA 타이거즈</option>
                        <option value="LG">LG 트윈스</option>
                        <option value="SSG">SSG 랜더스</option>
                        <option value="NC">NC 다이노스</option>
                        <option value="KT">KT 위즈</option>
                    </select>
                </div>

            </div>

            <div class="form-container" style="float:left;padding-left:10vw;">
                    <button type="submit" style="width:80vw;">Sign Up</button>
                    <p>Already a user? <a href="login.php">Log In</a></p>
                    <div>
            </form>
    </main>

    <script src="./js/password-confirm.js"></script>

<?php include_once './includes/footer.php'; ?>