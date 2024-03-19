<?php
// DB 연결 설정
session_start();
include_once './includes/config.php';

// 업로드 디렉토리 설정
$uploadDirectory = 'uploads/';

// 업로드할 파일 정보 확인
$userid = $_SESSION['user_id'];
$file = $_FILES['image'];
$filename = $file['name'];
$tmpFilePath = $file['tmp_name'];
$imageId = $_POST['ticket'];
$ticketId=$_POST['ticketId'];
$width = 600;
$height = 0;


// 파일을 업로드할 경로 설정
$destination = $uploadDirectory . $filename;

// 파일을 지정된 경로로 이동
if (move_uploaded_file($tmpFilePath, $destination)) {
    // 파일 업로드 성공

    
    try {
        //사진 이미지 회전 문제
        imagRotateResolve($destination,$filename);
    } catch (Exception $e) {   
    }
    
    $uploadeFileImage=getcwd()."/".$uploadDirectory. $filename;
    
    //업로된 파일 정보 가저오기
    $info_image=getimagesize($uploadeFileImage);
    if($info_image[0] > 600){  //이미지의 가로길이가 400 크면 썸네일 생성
        //티켓별 썸네일 가로 세로 사이즈 조절
       // getWidthAndHeight($ticketId);
        $gi_joon = "600";
        $imagehw = getImageSize($destination);
        $imagewidth = $imagehw[0];
        $imageheight = $imagehw[1];
        $new_height = $imageheight * $gi_joon / $imagewidth ;
        $new_height=ceil($new_height);
        $new_width = $gi_joon;
        
        $save_filename=$uploadDirectory."thumb_".$filename;
       
        
        thumbnail($uploadeFileImage, $save_filename ,$new_width, $new_height);
        
        
        $destination=$save_filename;
    }
    
    
    
    // 이미지 경로를 DB에 저장
    $sql = "INSERT INTO ticket_images (image_path, user_id, imageId) VALUES ('$destination', $userid, '$imageId')
        ON DUPLICATE KEY UPDATE image_path = VALUES(image_path)";
    
   
 
    
    if (mysqli_query($conn, $sql)) {
        
        $response = [
            'success' => true,
            'imageUrl' => $destination,
            'ticketId'=>$ticketId
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'DB 저장 실패'
        ];
    }
} else {
    // 파일 업로드 실패
    $response = [
        'success' => false,
        'message' => '파일 업로드 실패'
    ];
}
// 응답 데이터 전송
header('Content-Type: application/json');
echo json_encode($response);




// 원본 이미지 -> 썸네일로 만드는 함수
function thumbnail($file, $save_filename, $max_width, $max_height){
    $src_img = ImageCreateFromJPEG($file); //JPG파일로부터 이미지를 읽어옵니다
    
    $img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다
    $img_width = $img_info[0];
    $img_height = $img_info[1];
    
    
    
    if(($img_width/$max_width) == ($img_height/$max_height)){
        //원본과 썸네일의 가로세로비율이 같은경우
        $dst_width=$max_width;
        $dst_height=$max_height;
    }elseif(($img_width/$max_width) < ($img_height/$max_height)){
        //세로에 기준을 둔경우
        $dst_width=$max_height*($img_width/$img_height);
        $dst_height=$max_height;
    }else{
        //가로에 기준을 둔경우
        $dst_width=$max_width;
        $dst_height=$max_width*($img_height/$img_width);
    }//그림사이즈를 비교해 원하는 썸네일 크기이하로 가로세로 크기를 설정합니다.
    
    $dst_width=floor($dst_width);
    $dst_height=floor($dst_height);
    
    
    
    $dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다
    
    
    ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다

    ImageInterlace($dst_img);
    ImageJPEG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
    
    
    ImageDestroy($dst_img);
    ImageDestroy($src_img);    
}

//티켓별 썸네일 사이즈 크기조절
function getWidthAndHeight($ticketId){
    if($ticketId=="group-ticket3"){
        $width = 230;
        $height = 305;
    }elseif ($ticketId=="group-ticket4"){
        $width = 263;
        $height = 159;
        
    }elseif ($ticketId=="group-ticket5"){
        $width = 262;
        $height = 159;
    }
}


function imagRotateResolve($source_path ,$filename){
    /**
     * @description 스마트폰, 카메라 등에서 사진 jpg 저장시에
     회전값이 들어갈 수 있다. 그럴 경우 변환해 주는 소스 이다.
     */
    if(!function_exists('exif_read_data')){
        //echo 'not defined exif_read_data. requires exif module';
        return ;
    }
    if(!function_exists('imagecreatefromjpeg')){
        //echo 'not defined imagecreatefromjpeg.';
        return;
    }
    if(!function_exists('imagerotate')){
        //echo 'not defined imagerotate.';
        return;
    }
    
    
    $temp_ext = strrchr($source_path, ".");
    $temp_ext = strtolower($temp_ext);// 확장자
    if(preg_match('/(jpg|jpeg)$/i',$temp_ext)
        && function_exists('exif_read_data')
        && function_exists('imagecreatefromjpeg')
        && function_exists('imagerotate')
        )
    {
        $exif = exif_read_data($source_path);//<get exif data. jpeg 나 tiff 의 경우에만 갖고 있음
        $imageResource  = imagecreatefromjpeg($source_path);//<임시 리소스 생성
        
        if(!empty($exif['Orientation'])){
            
            //값에 따라 회전
            switch($exif['Orientation']){
                case 8 :  $image = imagerotate($imageResource ,90,0); break;
                case 3 :  $image = imagerotate($imageResource ,180,0); break;
                case 6 :  $image= imagerotate($imageResource ,-90,0); break;
            }
            
            //결과 처리
            if(!empty($image)){
                imagejpeg($image, $source_path);
                imagedestroy($imageResource);
                imagedestroy($image);
            }
        }
    }
}


// 원본 파일(경로포함), 저장될 경로 및 파일명
function auto_rotation_save($source_file, $dst_dir) {
    
    $imgsize = getimagesize($source_file);
    $mime = $imgsize['mime'];
    
    switch($mime){
        case 'image/gif':
            $image_create = 'imagecreatefromgif';
            $image = 'imagegif';
            break;
            
        case 'image/png':
            $image_create = 'imagecreatefrompng';
            $image = 'imagepng';
            break;
            
        case 'image/jpeg':
            $image_create = 'imagecreatefromjpeg';
            $image = 'imagejpeg';
            break;
            
        default:
            return false;
            break;
    }
    
    $im = $image_create($source_file);
    
    $exif = exif_read_data($source_file);
    if(!empty($exif['Orientation'])) {
        switch($exif['Orientation']) {
            case 8:
                $im = imagerotate($im, 90, 0);
                break;
            case 3:
                $im = imagerotate($im, 180, 0);
                break;
            case 6:
                $im = imagerotate($im, -90, 0);
                break;
        }
    }
    
    $image($im, $dst_dir, 95);
    
    if($im)imagedestroy($im);
    
}


?>
