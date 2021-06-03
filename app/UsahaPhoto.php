<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsahaPhoto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usaha_photo';

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    protected $fillable = [
		'usaha_id',
		'photo',
		'tanggal',
		'deskripsi',
	];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
