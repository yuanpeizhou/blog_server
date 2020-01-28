<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{

    /**
     * 指定该模型绑定的表名，如不指定则默认表名为bases
     */
    protected $table = 'blog_comment';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 模型的日期字段的存储格式
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 自定义用于存储时间戳的字段名
     */
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * 此模型的连接名称(指定该模型连接那个数据库)。
     *
     * @var string
     */
    protected $connection = 'connection-name';

    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name'];
}