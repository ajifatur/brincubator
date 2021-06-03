<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramUsaha extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_usaha';
    
    // primary key
    protected $primaryKey = 'id_program_usaha';

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    protected $fillable = [
		'pelatihan_id',
		'usaha_id',
	];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
