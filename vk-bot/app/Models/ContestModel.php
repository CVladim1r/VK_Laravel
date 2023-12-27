<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contest;

class ContestModel extends Model
{
    protected $table = 'contests';
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'image',
        'draw_time',
        'public_id', // Ссылка на паблик
    ];

    /**
     * Define the relationship between Contest and PublicModel model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function public()
    {
        return $this->belongsTo(PublicModel::class, 'public_id', 'id');
    }

    /**
     * Define the relationship between Contest and Prize model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function prize()
    {
        return $this->hasOne(Prize::class);
    }

    /**
     * Define the relationship between Contest and Task model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task()
    {
        return $this->hasOne(Task::class);
    }

    /**
     * Create a new contest in the database.
     *
     * @param array $data
     * @return \App\Models\Contest
     */
    public static function createContest(array $data)
    {
        return static::create([
            'text' => $data['text'],
            'image' => $data['image'],
            'draw_time' => $data['draw_time'],
            'public_id' => $data['public_id'],
        ]);
    }

    /**
     * Update the contest in the database.
     *
     * @param array $data
     * @return bool
     */
    public function updateContest(array $data)
    {
        return $this->update([
            'text' => $data['text'],
            'image' => $data['image'],
            'draw_time' => $data['draw_time'],
            'public_id' => $data['public_id'],
        ]);
    }

    /**
     * Delete the contest from the database.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteContest()
    {
        return $this->delete();
    }
}
