document.getElementById('addExtraInputBtn').addEventListener('click', addExtraInput);

function togglePages() {
    const isChecked = document.getElementById("toggleInput").checked;
    const form1 = document.getElementById("gameForm");
    const form2 = document.getElementById("gameForm2");

    if (isChecked) {
        form1.style.display = "block";
        form2.style.display = "none";
    } else {
        form1.style.display = "none";
        form2.style.display = "block";
    }
}
function updateWatchedGameValue() {
    const watchedGameInput = document.getElementById('watchedGame');
    watchedGameInput.value = watchedGameInput.checked ? 'yes' : 'no';
}
let extraInputCounter = 1;
let extraInputData = {};  // extraInputData 객체를 추가합니다.

function getExtraInput(counter, data) {
    extraInputCounter = counter;
    extraInputData = data;
}

function addExtraInput() {
    const extraInputsContainer = document.getElementById('extraInputs');
    const newExtraInfoLabel = document.getElementById('newExtraInfoLabel');

    if (newExtraInfoLabel.value.trim() === '') {
        alert('라벨을 입력해주세요.');
        return;
    }

    const newInputLabel = document.createElement('label');
    newInputLabel.textContent = newExtraInfoLabel.value;
    newInputLabel.htmlFor = 'newExtraInfo';
    newInputLabel.style.marginRight = '24px';

    const newInput = document.createElement('input');
    newInput.type = 'text';
    newInput.id = `newExtraInfo${extraInputCounter}`;
    newInput.name = `newExtraInfo${extraInputCounter}`;
    newInput.required = true;
    newInput.placeholder = `${newExtraInfoLabel.value}를(을) 입력하세요`;

    // extraInputData 객체에 추가 정보를 저장합니다.
    extraInputData[`newExtraInfo${extraInputCounter}`] = {
        label: newExtraInfoLabel.value,
        value: null  // 값은 아직 설정되지 않았습니다.
    };

    extraInputsContainer.appendChild(newInputLabel);
    extraInputsContainer.appendChild(newInput);

    // 입력 완료 후 라벨 입력란 초기화
    newExtraInfoLabel.value = '';

    // 카운터 값을 증가시킵니다.
    extraInputCounter++;
    document.getElementById("extraInputCount").value = extraInputCounter;
}



let uploadedFiles = [];
const addImageBtn = document.getElementById("addImageBtn");
const addVideoBtn = document.getElementById("addVideoBtn");
const fileUpload = document.getElementById("fileUpload");
const videoUpload = document.getElementById("videoUpload");
const carouselImages = document.getElementById("carouselImages");
const videoContainer = document.querySelector(".video-container");

addImageBtn.addEventListener("click", () => {
    fileUpload.click();
});

addVideoBtn.addEventListener("click", () => {
    videoUpload.click();
});

fileUpload.addEventListener("change", (event) => {
    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        let reader = new FileReader();
        uploadedFiles.push(files[i]);

        const newImageDiv = document.createElement("div");
        newImageDiv.className = "slide";
        if (carouselImages.childElementCount === 0) {
            newImageDiv.classList.add("active");
        }

        reader.onload = (e) => {
            newImageDiv.style.backgroundImage = `url(${e.target.result})`;
            carouselImages.appendChild(newImageDiv);
        }

        reader.readAsDataURL(files[i]);
    }

    fileUpload.value = "";  // 파일 선택 초기화
});


videoUpload.addEventListener("change", (event) => {
    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        let reader = new FileReader();
        uploadedFiles.push(files[i]); // 선택한 파일을 uploadedFiles 배열에 추가

        reader.onload = (e) => {
            const newVideo = document.createElement("video");
            newVideo.src = e.target.result;
            newVideo.controls = true;
            videoContainer.appendChild(newVideo);
        }

        reader.readAsDataURL(files[i]);
    }

    videoUpload.value = "";  // 파일 선택 초기화
});


const form = document.getElementById("gameForm2");
const submitBtn = document.getElementById("submitBtn2");

submitBtn.addEventListener("click", function (event) {
    event.preventDefault(); // 기본 폼 제출 동작 방지

    // extraInputData 객체의 값들을 업데이트합니다.
    Object.keys(extraInputData).forEach((key) => {
        const inputElement = document.getElementById(key);
        if (inputElement) {
            extraInputData[key].value = inputElement.value;
        }
    });

    const formData = new FormData(form);

    // extraInputData 객체를 JSON 문자열로 변환하여 폼 데이터에 추가합니다.
    formData.append("extraInputData", JSON.stringify(extraInputData));

    // 업로드된 파일을 FormData에 추가
    for (let i = 0; i < uploadedFiles.length; i++) {
        formData.append("uploadedFiles[]", uploadedFiles[i]);
    }

    // URL의 쿼리 문자열에서 날짜 정보를 추출합니다.
    const urlParams = new URLSearchParams(window.location.search);
    const year = urlParams.get('year');
    const month = urlParams.get('month');
    const date = urlParams.get('date');
    formData.append('year', year);
    formData.append('month', month);
    formData.append('date', date);

    for (let pair of formData.entries()) {
        console.log(pair[0]+ ', '+ pair[1]);
    }

    // FormData를 사용하여 폼 데이터를 서버로 전송
    $.ajax({
        type: 'POST',
        data: formData,
        url: 'write_game2.php',
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            if (response.success) {
                alert('정보가 성공적으로 저장되었습니다');
            } else {
                alert('Failed to insert data.');
            }
        },
        error: function(error) {
            console.log(error);
            alert('Unexpected error occured. Please try again.');
        }
    });
});

let currentSlide = 0;

const updateSlides = () => {
    const slides = document.querySelectorAll(".slide");
    slides.forEach((slide, index) => {
        if (index === currentSlide) {
            slide.classList.add("active");
        } else {
            slide.classList.remove("active");
        }
    });
};

// 파일 객체 배열로 변환하는 함수
const convertToFileObjects = (filePaths) => {
    return filePaths.map((file, index) => {
        const fileName = file.substring(file.lastIndexOf('/') + 1);
        const fileExtension = fileName.substring(fileName.lastIndexOf('.'));
        return new File([null], fileName, { type: `${fileExtension}`.toLowerCase() });
    });
};

function getFile(filePaths) {
// 파일 객체 배열 생성
    uploadedFiles = convertToFileObjects(filePaths);

    for (let i = 0; i < uploadedFiles.length; i++) {
        const newImageDiv = document.createElement("div");
        const newVideo = document.createElement("video");

        if(uploadedFiles[i].type === '.mp4') {
            newVideo.src = `./uploads/${uploadedFiles[i].name}`;
            newVideo.controls = true;
            videoContainer.appendChild(newVideo);
        } else {
            console.log(1);
            newImageDiv.className = "slide";
            if (carouselImages.childElementCount === 0) {
                newImageDiv.classList.add("active");
            }

            newImageDiv.style.backgroundImage = `url(./uploads/${uploadedFiles[i].name})`;
            carouselImages.appendChild(newImageDiv);
        }
    }


    fileUpload.value = "";  // 파일 선택 초기화
}

const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

prevBtn.addEventListener("click", () => {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = carouselImages.children.length - 1;
    }
    updateSlides();
});

nextBtn.addEventListener("click", () => {
    currentSlide++;
    if (currentSlide >= carouselImages.children.length) {
        currentSlide = 0;
    }
    updateSlides();
});

$(document).ready(function(){
    $('#gameForm').submit(function(e){
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        // Get the date from the URL query string
        var urlParams = new URLSearchParams(window.location.search);
        var year = urlParams.get('year');
        var month = urlParams.get('month');
        var date = urlParams.get('date');

        // Add the date to the form data
        var formData = form.serialize();
        formData += '&year=' + year + '&month=' + month + '&date=' + date;

        $.ajax({
            type: "POST",
            url: url,
            data: formData, // serializes the form's elements.
            success: function(data)
            {
                alert(data); // show response from the PHP script.
            }
        });
    });
});
