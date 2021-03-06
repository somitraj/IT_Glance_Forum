<?php namespace IT_Glance_Forum\Models;

use Illuminate\Database\Eloquent\Model;

class PostTbl extends Model {

    /**
     * Generated
     */

    protected $table = 'post_tbl';
    protected $fillable = ['id', 'user_id', 'post_title', 'post_body', 'start_datetime', 'end_datetime', 'status_id', 'post_type_id', 'category_id'];


    public function categoryTbl() {
        return $this->belongsTo('IT_Glance_Forum\Models\CategoryTbl', 'category_id', 'id');
    }

    public function posttypeTbl() {
        return $this->belongsTo('IT_Glance_Forum\Models\PosttypeTbl', 'post_type_id', 'id');
    }

    public function statusTbl() {
        return $this->belongsTo('IT_Glance_Forum\Models\StatusTbl', 'status_id', 'id');
    }

    public function usersTbl() {
        return $this->belongsTo('IT_Glance_Forum\Models\UsersTbl', 'user_id', 'id');
    }

    public function usersTbls() {
        return $this->belongsToMany('IT_Glance_Forum\Models\UsersTbl', 'comment_tbl', 'post_id', 'user_id');
    }

    public function commentTbls() {
        return $this->hasMany('IT_Glance_Forum\Models\CommentTbl', 'post_id', 'id');
    }


}
