<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'izin';

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    protected $fillable = [
		'akte_notaris',
        'badan_hukum',
        'siup',
        'npwp',
        'tdp',
        'lain',
	];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
