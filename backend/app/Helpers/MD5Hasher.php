<?php

namespace App\Helpers;

use Illuminate\Contracts\Hashing\Hasher;

class MD5Hasher implements Hasher{
    public function info($hashedValue){
        return $this->driver('md5')->info($hashedValue);
    }

    public function check($value, $hashedValue, array $options = []){
        //return $this->make($value) === $hashedValue;
        return $value === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = []){
        return false;
    }

    public function make($value, array $options = []){
        $value = env('SALT', '').$value;

        return md5($value);
    }
}