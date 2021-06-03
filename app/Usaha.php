<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usaha extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usaha';

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    protected $fillable = [
		'pemilik_id',
        'bidang_id',
        'izin_id',
        'mentor_id',
        'nama_usaha',
        'tahun_berdiri',
        'alamat_usaha',
        'notelp',
        'email',
        'website',
        'kredit_bank',
        'tenaga_kerja',
        'wilayah_id',
	];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
