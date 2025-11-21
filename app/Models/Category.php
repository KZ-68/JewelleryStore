<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'category_position',
        'index'
    ];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Create a slug automaticaly after the creation of the category
            $slug = Str::slug($category->name);
            $count = Category::where('slug', $slug)->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }

            $category->slug = $slug;
            // Add home category to parent_id by default
            if($category->parent_id == null) {
                $category->parent_id = 1;
            }
        });
    }

    /**
     * Get the sub categories.
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

     /**
     * The products that belong to the category.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s'
        ];
    }
}