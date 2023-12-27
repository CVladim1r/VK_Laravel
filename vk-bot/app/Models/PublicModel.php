<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicModel extends Model
{
    protected $table = 'publics';

    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vk_id',
        'name',
        'token',
        // Другие необходимые поля
    ];

    /**
     * Define the relationship between PublicModel and Contest model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contests()
    {
        return $this->hasMany(Contest::class);
        return $this->hasMany(ContestModel::class, 'public_id', 'id');
    }

    /**
     * Create a new public in the database.
     *
     * @param array $data
     * @return \App\Models\PublicModel
     */
    public static function createPublic(array $data)
    {
        return static::create([
            'vk_id' => $data['vk_id'],
            'name' => $data['name'],
            'token' => $data['token'],
        ]);
    }

    

    /**
     * Update the public in the database.
     *
     * @param array $data
     * @return bool
     */
    public function updatePublic(array $data)
    {
        return $this->update([
            'vk_id' => $data['vk_id'],
            'name' => $data['name'],
            'token' => $data['token'],
        ]);
    }

    /**
     * Delete the public from the database.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deletePublic()
    {
        return $this->delete();
    }
}
