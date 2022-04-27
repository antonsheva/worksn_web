<?php
namespace classesPhp;
global $A_start;

use function PHPSTORM_META\elementType;
use structsPhp\Dir;
use structsPhp\G;

if($A_start != 444){echo 'byby';exit();}



class ClassImg{

    function cancelAddImg(){

    }
    function addImg(){
        global $G, $S, $P, $DIR;

        $createId = $P->AGet(STR_CREATE_ID);

        if($S->AGet(STR_LOAD_IMGS_QT)){
            $S->ASet(STR_LOAD_IMGS_QT, $S->AGet(STR_LOAD_IMGS_QT)+1);
        }else{
            $S->ASet(STR_LOAD_IMGS_QT, 1);
        }
        if($S->AGet(STR_LOAD_IMGS_QT) > MAX_LOAD_IMG_QT){
            $S->ASet(STR_LOAD_IMGS_QT, MAX_LOAD_IMG_QT);
            mRESP_WTF(STRING_MAX_LOAD_IMG_QT);
        }

        if(isset($_FILES['userfile']['size'])){
            $ext_file_arr = array('jpg','img','jpeg','png','gif','webp');
            $file = pathinfo($_FILES['userfile']['name']);
            $fileName = substr($file['filename'], 0,20);
            $file_size = $_FILES['userfile']['size'];
            $ext_file = mb_strtolower($file['extension']);
            if(!(in_array($ext_file,$ext_file_arr)))mRESP_WTF(STRING_FORMAT_.$ext_file.STRING_NOT_AVAILABLE);
            if($file_size > MAX_FILE_SIZE)mRESP_WTF(STRING_FILE_TOO_LARGE);
            $fileName  .= '_'.$G->nSecTime.'_'.$G->time;
            $fileNameFull = $fileName.'.'.$ext_file;

            $uploadfile = PATH_TMP_IMG.'f1/'.$fileNameFull;

            if (!(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)))mRESP_WTF(STRING_SOME_THROWABLE);


            if ($ext_file == 'webp'){
                $tmp = $uploadfile;
                $info = pathinfo($uploadfile);
                $img = imagecreatefromwebp($uploadfile);
                imageJpeg($img, $info['dirname'] . '/' . $info['filename'] . '.jpg', IMG_QUALITY);
                imagedestroy($img);
                unlink($tmp);
                $fileNameFull = $fileName.'.jpg';
            }

            $this->transformImg($fileNameFull, PATH_TMP_IMG, MAX_IMG_SIZE, 1);
            $outFile = PATH_TMP_IMG.$fileNameFull;
            $S->ASet(STR_TMP_IMG, $outFile);

            $this->transformImg($fileNameFull, PATH_TMP_IMG_ICON, MAX_ICON_SIZE, 0);

            $outFilePathIcon = PATH_TMP_IMG_ICON.$fileNameFull;
            $S->ASet(STR_TMP_IMG_ICON, $outFilePathIcon);

            $this->removeImg($uploadfile);

            $imgData = $this->bindImgToMsg($createId, $outFile);
            if (is_array($imgData)){
                $data = new \SaveImgData();
                $data->create_id   = $createId;
                $data->img         = $imgData[STR_IMG];
                $data->img_icon    = $imgData[STR_IMG_ICON];
                $data->msg_id      = $imgData[STR_MSG_ID];
                $data->consumer_id = $imgData[STR_CONSUMER_ID];
                $G->saveImgData = $data;
                $this->removeOldImgsFromSession();
                mRESP_DATA(0);
            }
            if (!$imgData){
                $G->tmp_img      = $outFile;
                $G->tmp_img_icon = $outFilePathIcon;
                $this->addLoadImgToSession($G->tmp_img);
                mRESP_DATA(0);
            }
            else
                mRESP_WTF(STRING_SOME_THROWABLE);
        }
        mRESP_WTF(STRING_SOME_THROWABLE);
    }
    function copyImgsToTmpFolder($imgList, $imgListIcon){
        $filesString = '';
        $imgCnt = 0;
        $data = array();
        if ($imgList){
            if (strlen($imgList)>10){
                $imgArray     = explode(',',$imgList);
                $imgArrayIcon = explode(',',$imgListIcon);
                foreach ($imgArray as $item){
                    $fileName = $this->getFileNameFromPath($item);
                    try{
                        if (file_exists($item))
                            copy($item , PATH_TMP_IMG.$fileName);
                    }catch (\Exception $e){

                    }
                }
                foreach ($imgArrayIcon as $item){
                    $fileName = $this->getFileNameFromPath($item);
                    try{
                        if (file_exists($item)){
                            $res = copy($item , PATH_TMP_IMG_ICON.$fileName);
                            if ($res){
                                $filesString.=$fileName.',';
                                $imgCnt++;
                            }
                        }

                    }catch (\Exception $e){
                        
                    }
                }
            }
        }
        $data[STR_IMG_LIST] = $filesString;
        $data[STR_IMG_CNT]  = $imgCnt;
        return $data;
    }
    function getUniqueFileName($fileName, $destFolder){
        if (file_exists($destFolder.'/'.$fileName)){
            $fileName = 'f_'.rand(0,100).'_'.substr($fileName, 5);
            $this->getUniqueFileName($fileName, $destFolder);
        }
        return $fileName;
    }
    function bindImgToMsg($createId, $filePath){
        global $A_db, $DIR;
        $query = "SELECT id, consumer_id FROM msg WHERE create_id='$createId'";
        $res = $A_db->AGetSingleStringFromDb($query);
        if ($res){
            $id = $res[STR_ID];
            $consumerId = $res[STR_CONSUMER_ID];
            $imgData = $this->saveImg($filePath, PATH_MSG_IMGS);
            $img     = $imgData[STR_IMG];
            $imgIcon = $imgData[STR_IMG_ICON];
            $query = "UPDATE msg SET img='$img',img_icon='$imgIcon', create_id=NULL WHERE id='$id'";
            $res = $A_db->AQueryToDB($query);
            if ($res){
                $imgData[STR_MSG_ID] = $id;
                $imgData[STR_CONSUMER_ID] = $consumerId;
                return $imgData;
            }
            else {
                return -1;
            }
        }
        return null;
    }
    function bindImgToAds(){

    }
    function addLoadImgToSession($img){
        global $S;
        $imgName = $this->getFileNameFromPath($img);
        $tmp = $S->AGet(STR_LOAD_IMGS);
        $S->ASet(STR_LOAD_IMGS, $tmp . $imgName.',');
    }
    function removeOldImgsFromSession(){
        global $S, $DIR;
        $S->ASet(STR_TMP_IMG, null);
        $S->ASet(STR_LOAD_IMGS_QT, 0);
        if(($S->AGet(STR_LOAD_IMGS) != null) && ($S->AGet(STR_LOAD_IMGS) != ' ')){
            $arr = explode(',', $S->AGet(STR_LOAD_IMGS));
            foreach ($arr as $item){
                if($item){
                    $this->removeImg(PATH_TMP_IMG.$item);
                    $this->removeImg(PATH_TMP_IMG_ICON.$item);
                }
            }
        }
        $S->ASet(STR_LOAD_IMGS, '');
    }
    function saveImg($img, $path){
        global $G;

        $f1 = 'f1_'.substr($G->nSecTime, strlen($G->nSecTime) - 4, 2);
        $f2 = 'f2_'.substr($G->nSecTime, strlen($G->nSecTime) - 2, 2);
        $newPath     = $path.'/'.$f1.'/'.$f2.'/';
        $newIconPath = $path.'_icon/'.$f1.'/'.$f2.'/';
        if(!is_dir($newPath)){
            if(!mkdir($newPath, 0755,true))mRESP_WTF(__CLASS__);
        }
        if(!is_dir($newIconPath)){
            if(!mkdir($newIconPath, 0755,true))mRESP_WTF(__CLASS__);
        }
        $tmpArr = explode('/', $img);

        $imgName     = $tmpArr[count($tmpArr)-1];
        $tmpImgIcon  = PATH_TMP_IMG_ICON.$imgName;

        $newName     = $newPath.$imgName;
        $newIconName = $newIconPath.$imgName;
        $data[STR_IMG]     = $newName;
        $data[STR_IMG_ICON] = $newIconName;
        if(is_writable($img))
            if(is_file($img))
                rename($img, $newName);
        if(is_writable($tmpImgIcon))
            if(is_file($tmpImgIcon))
                rename($tmpImgIcon, $newIconName);
        return $data;
    }
    function removeImg($img_file){
        global $DIR;
        if ($img_file == URL_IMG_NO_AVATAR)return OK;
        try{
            if(file_exists($img_file))
                if(is_file($img_file))
                    if(is_writable($img_file))
                        unlink($img_file);
            return OK;
        }catch (\Exception $e){
            return ERROR;
        }
    }
    function removeFileList($fileList = null, $exit = 1){
        global $P;
        $cnt = 0;
        $errCnt = 0;
        $errFiles = '';
        if (is_null($fileList))$fileList = $P->AGet(STR_IMG_LIST);
        if ($fileList){
            if (strlen($fileList>10)){
                $arr = explode(',', $fileList);
                foreach ($arr as $item){
                    if ($this->removeImg($item)){
                        $errCnt++;
                        $errFiles.=$item.',';
                    } else
                        $cnt++;
                }
            }
        }
        if ($exit)mRESP_DATA($errFiles, $errCnt);
        $data['errFiles'] = $errFiles;
        $data['errCnt'] = $errCnt;
        return $data;
    }
    function removeTmpFiles($fileList = null){
        global $P;
        $cnt = 0;
        if (is_null($fileList))$fileList = $P->AGet(STR_IMG_LIST);
        if ($fileList){
            if (strlen($fileList>10)){
                $arr = explode(',', $fileList);
                foreach ($arr as $item){
                    $this->removeTmpFile($this->getFileNameFromPath($item), false);
                    $cnt++;
                }
            }
        }
        mRESP_DATA(0);
    }
    function removeTmpFile($fileName = null, $exit = true){
        global $S, $P, $DIR, $G;

        if(is_null($fileName)){
            if($P->AGet(STR_FILE_NAME)){
                $fileName = $this->getFileNameFromPath($P->AGet(STR_FILE_NAME));
            }else{
                $fileName = $this->getFileNameFromPath($S->AGet(STR_TMP_IMG));
            }
        }

        $this->removeImg(PATH_TMP_IMG.$fileName);
        $this->removeImg(PATH_TMP_IMG_ICON.$fileName);
        $S->ASet(STR_TMP_IMG, null);

        if($S->AGet(STR_LOAD_IMGS_QT)){
            $qt = $S->AGet(STR_LOAD_IMGS_QT)-1;
            $S->ASet(STR_LOAD_IMGS_QT, $qt);
        }
        $G->tmp_img      = PATH_TMP_IMG.$fileName;
        $G->tmp_img_icon = PATH_TMP_IMG_ICON.$fileName;
        if ($exit)mRESP_DATA(0, $S->AGet(STR_LOAD_IMGS_QT));
        return;
    }
    function getFileNameFromPath($filePath){
        $fileName = '';
        $arr = array();
        try{
            $arr[] = explode('/',$filePath);
            $fileName = $arr[0][count($arr[0])-1];
        }catch (\Exception $e){
            global $LOG;
            $LOG->write(__FILE__.'func - '.__FUNCTION__.'line - '.__LINE__.'; ');
            $LOG->write('ERROR_GET_FILENAME, getFileNameFromPath; ');
            mRESP_WTF( 'func - '.__FUNCTION__.'line - '.__LINE__.'; ');
        }
        return $fileName;
    }

    function transformImg($fileName, $outputPath, $imgSize, $proportion = false){
        global $LOG, $G;
        $shift_x = $shift_y = 0;
        if(file_exists(PATH_INPUT_IMG.$fileName)){
            $input_file = PATH_INPUT_IMG.$fileName;
            list($img_w, $img_h, $file_type) = getimagesize($input_file);
            if(!$img_w || !$img_h) {
                $LOG->write(__FILE__.'func - '.__FUNCTION__.'line - '.__LINE__);
                $LOG->write('ERROR_LOAD_IMG,ASaveAvatar');
                mRESP_WTF('ERROR_LOAD_IMG;  func -> '.__FUNCTION__.'; line -> '.__LINE__);
            }
            $types = array('jpg','gif','jpeg','png','webp');
            $ext = $types[$file_type];
            $file_src = null;
            if ($ext) {
                $func = 'imagecreatefrom'.$ext;
                $file_src = $func($input_file);
            } else {
                $LOG->write(__FILE__.'func - '.__FUNCTION__.'line - '.__LINE__);
                $LOG->write('ERROR_FILE_TYPE,ASaveAvatar');
                mRESP_WTF('ERROR_FILE_TYPE,ASaveAvatar');
            }
            if($proportion){
                if(($imgSize<$img_w)||($imgSize<$img_h)){
                    if($img_w>$img_h){$ratio = $img_w/$imgSize;$out_w = $imgSize; $out_h = $img_h/$ratio;}
                    else             {$ratio = $img_h/$imgSize;$out_h = $imgSize; $out_w = $img_w/$ratio;}
                }else{$out_w=$img_w; $out_h=$img_h;}
                $file_out = imagecreatetruecolor($out_w, $out_h);
                imagecopyresampled($file_out,$file_src,0,0,0,0,$out_w,$out_h,$img_w,$img_h);
                $func = 'image'.$ext;
                $func($file_out,$outputPath.$fileName);
            }else{
                $file_out = imagecreatetruecolor($imgSize,$imgSize);
                if($img_w>$img_h){$img_cut_h=$img_cut_w=$img_h;$shift_x = (($img_w-$img_h)/2);}
                else             {$img_cut_h=$img_cut_w=$img_w;$shift_y = (($img_h-$img_w)/2);}
                $tmp_img = imagecreatetruecolor($img_cut_w,$img_cut_h);
                imagecopy($tmp_img,$file_src,0,0,$shift_x,$shift_y,$img_cut_w,$img_cut_h);
                imagecopyresampled($file_out,$tmp_img,0,0,0,0,$imgSize,$imgSize,$img_cut_w,$img_cut_h);
                $func = 'image'.$ext;
                $func($file_out,$outputPath.$fileName);
            }
        }
    }
}