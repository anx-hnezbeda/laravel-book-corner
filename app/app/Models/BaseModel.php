<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BaseModel
 * @package App\Models
 */
abstract class BaseModel extends Model {
	use SoftDeletes;
	use Timestamp;

}