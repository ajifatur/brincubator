<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mentor';

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
		'tempat_lahir',
		'tanggal_lahir',
		'alamat',
		'pekerjaan',
		'alamat_kantor',
		'jabatan',
		'email',
		'pendidikan_terakhir',
		'notelp',
		'nama_usaha',
        'wilayah_id',
	];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
