<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account extends Model
{
    private int $id;
    private string $name;

    
    public function __construct(int $id, string $name){
        $this->id = $id;
        $this->name = $name;
    }

    
}
