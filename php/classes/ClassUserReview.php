<?php
namespace classesPhp;
global $A_start;

if($A_start != 444){echo BYBY; exit();}

class ClassUserReview{
    var $review;
    var $rating;
    var $vote_qt;
    function __construct()
    {
        global $G;
        $this->review = new \structsPhp\dbStruct\tblUserReview();
        if($G->user->id && $G->owner->id){
            $this->searchExistUserReview();
            if($this->review->id)$G->selfReview = $this->review;
        }
        if($G->location_page===PAGE_USER_PROFILE && $G->owner->id)$this->getUserReviews();
    }
    function getUserReviews(){
        global $A_db, $G;

        $query = "SELECT sender_id, comment, create_date FROM user_reviews WHERE consumer_id='$G->owner_id' ORDER BY create_date DESC LIMIT 100";
        $G->userReviews = $A_db->AGetMultiplyDataFromDb($query);
        foreach($G->userReviews as &$item){
            if($item[STR_SENDER_ID] != $G->user_id)unset($item[STR_SENDER_ID]);
        }
    }
    function getUserData(){
        $this->getUserReviews();
        mRESP_DATA(0);
    }
    function addUserReview(){
        global $G, $A_db, $P;
        if($G->user->id && $G->owner->id){
            $comment = $P->AGet(STR_TXT_REVIEW);
            $star_qt = $P->AGet(STR_STAR_QT);
            $this->review->sender_id = $G->user->id;
            $this->review->consumer_id = $G->owner->id;
            $this->searchExistUserReview();
            $this->review->create_date = $G->dateFull;
            if($comment)$this->review->comment = $comment;
            $rating_data = array();
            if($star_qt){
                $this->review->star_qt = $star_qt;
                $A_db->ASaveDataToDb($this->review,TBL_USER_REVIEWS, $this->review->id);
                $this->calculateUserRating($G->owner->id);
                $rating_data[STR_RATING]  = $this->rating;
                $rating_data[STR_VOTE_QT] = $this->vote_qt;
                $G->owner->rating = $this->rating;
                $G->owner->vote_qt = $this->vote_qt;
                $A_db->ASaveDataToDb($rating_data, TBL_USERS, $G->owner->id);
                mRESP_DATA(0);
            }else{
                $res = $A_db->ASaveDataToDb($this->review,TBL_USER_REVIEWS, $this->review->id);
                if($res[STR_ID]){
                    $G->userReview = $this->review;
                    mRESP_DATA(0);
                }
            }
        }
        mRESP_WTF();
    }
    function searchExistUserReview(){
        global $A_db, $G;
        $sender_id   = $G->user->id;
        $consumer_id = $G->owner->id;
        $query = "SELECT * FROM user_reviews WHERE (sender_id='$sender_id'  AND consumer_id='$consumer_id')";
        $res = $A_db->AGetSingleStringFromDb($query);
        if($res){
            $A_db->arrayToArrayNotNull($res, $this->review);
        }
    }
    function setBwStatus(){
        global $G, $P, $A_db, $S, $U, $LOG;
        $userId = $G->user->id;
        $subjectId = $P->AGet(STR_SUBJECT_ID);
        $status    = $P->AGet(STR_STATUS);
        $resArr = array();
        if (($subjectId === null) || ($status === null) || ($userId===null))$LOG->write('data error: status -> '.$status.'; subjectId -> '.$subjectId.'; userId -> '.$userId);
        switch ($status){
            case BW_STATUS_EMPTY : $resArr = $this->clearBwStatus($subjectId); break;
            case BW_STATUS_LIKE  : $resArr = $this->setBwLike($subjectId); break;
            case BW_STATUS_BAN   : $resArr = $this->setBwBan($subjectId); break;
        }
        $like = $resArr[STR_LIKE];
        $ban  = $resArr[STR_BAN];
        $dt = $resArr[STR_DATA];
        $query = "UPDATE users SET like_list='$like', ban_list='$ban' WHERE id='$userId'";
        $res = $A_db->AQueryToDB($query);
        if ($res){
            $S->ASet(STR_DATA_COMPLETE, 0);
            $q = $G->user->id;
            $U->user->id = $q;
            $U->AInitUser();
            mRESP_DATA(0);
        }
        else     mRESP_WTF();
    }
    private function setBwBan($subjectId){
        global $G;
        $stringLike = '';
        $stringBan  = '';
        $like = $G->user->like_list;
        $ban  = $G->user->ban_list;
        $like1 = explode('_', $like, 100);
        $ban1  = explode('_', $ban, 100);

        $indexLike = -1;
        $indexBan  = -1;
        for ($i = 0; $i < count($like1); $i++){
            if ($subjectId == $like1[$i]){
                $indexLike = $i;
                break;
            }
        }
        for ($i = 0; $i < count($ban1); $i++){
            if ($subjectId == $ban1[$i]){
                $indexBan = $i;
                break;
            }
        }
        if ($indexLike > -1)
            $like1[$indexLike] = null;

        if ($indexBan < 0)
            $ban1[] = $subjectId;

        foreach ($like1 as $val)
            if (($val !== null)&&($val !== ''))$stringLike.=$val.'_';

        foreach ($ban1 as $val)
            if (($val !== null)&&($val !== ''))$stringBan.=$val.'_';


        $res[STR_LIKE] = $stringLike;
        $res[STR_BAN]  = $stringBan;
        $data[] = $ban;
        $data[] = $like;
        $res[STR_DATA] = $data;
        return $res;
    }
    private function setBwLike($subjectId){
        global $G;
        $stringLike = '';
        $stringBan  = '';
        $like = $G->user->like_list;
        $ban  = $G->user->ban_list;
        $like = explode('_', $like, 100);
        $ban  = explode('_', $ban, 100);

        $indexLike = -1;
        $indexBan  = -1;
        for ($i = 0; $i < count($like); $i++){
            if ($subjectId == $like[$i]){
                $indexLike = $i;
                break;
            }
        }
        for ($i = 0; $i < count($ban); $i++){
            if ($subjectId == $ban[$i]){
                $indexBan = $i;
                break;
            }
        }

        if ($indexBan > -1)
            $ban[$indexBan] = null;

        if ($indexLike < 0)
            $like[] = $subjectId;

        foreach ($like as $val)
            if (($val !== null)&&($val !== ''))$stringLike.=$val.'_';

        foreach ($ban as $val)
            if (($val !== null)&&($val !== ''))$stringBan.=$val.'_';


        $res[STR_LIKE] = $stringLike;
        $res[STR_BAN]  = $stringBan;
        $data[] = $ban;
        $data[] = $like;
        $res[STR_DATA] = $data;

        return $res;
    }
    private function clearBwStatus($subjectId){
        global $G;
        $stringLike = '';
        $stringBan  = '';
        $like = $G->user->like_list;
        $ban  = $G->user->ban_list;
        $like = explode('_', $like);
        $ban  = explode('_', $ban);

        $indexLike = -1;
        $indexBan  = -1;
        for ($i = 0; $i < count($like); $i++){
            if ($subjectId == $like[$i]){
                $indexLike = $i;
                break;
            }
        }
        for ($i = 0; $i < count($ban); $i++){
            if ($subjectId == $ban[$i]){
                $indexBan = $i;
                break;
            }
        }

        if ($indexLike > -1)
            $like[$indexLike] = null;

        if ($indexBan > -1)
            $ban[$indexBan] = null;

        foreach ($like as $val)
            if (($val !== null)&&($val !== ''))$stringLike.=$val.'_';

        foreach ($ban as $val)
            if (($val !== null)&&($val !== ''))$stringBan.=$val.'_';

        $res[STR_LIKE] = $stringLike;
        $res[STR_BAN]  = $stringBan;
        $data[] = $ban;
        $data[] = $like;
        $res[STR_DATA] = $data;
        return $res;
    }
    private function calculateUserRating($id){
        global $A_db;
        $cnt=0;
        $rating = 0;
        $query = "SELECT star_qt FROM user_reviews WHERE (star_qt>0 AND consumer_id='$id')";
        $res = $A_db->AGetMultiplyDataFromDb($query);
        if($res){
            foreach ($res as $item){
                $cnt++;
                $rating+=(float)$item[STR_STAR_QT];
            }
            $this->rating  = (float)($rating/$cnt)*100;
            $this->vote_qt = $cnt;
        }

    }

    public function getBanUsers(){
        global $G, $A_db;
        $banList = $G->user->ban_list;
        $result = 0;
        if ($banList){
            $banList = explode('_', $banList, MAX_BAN_USERS_QT);
            if (count($banList) > 0){
                $result = count($banList);
                $G->usersList = $A_db->getUserList($banList);
            }
        }
        mRESP_DATA(0, $result);
    }
    public function getLikeUsers(){
        global $G, $A_db;
        $likeList = $G->user->like_list;
        $result = 0;
        if ($likeList){
            $likeList = explode('_', $likeList, MAX_LIKE_USERS_QT);
            if (count($likeList) > 0){
                $result = count($likeList);
                $G->usersList = $A_db->getUserList($likeList);
            }
        }
        mRESP_DATA(0, $result);
    }

}
