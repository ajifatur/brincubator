<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bidang';

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    protected $fillable = [
		'nama',
	];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
