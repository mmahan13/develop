<?php
/**
 * Created by PhpStorm.
 * User: agf
 * Date: 19/04/2017
 * Time: 16:34
 */

namespace App\libraries;

use Illuminate\Contracts\Hashing\Hasher;

class md5Hash implements Hasher
{
    /**
     * Hash the given value.
     *
     * @param  string $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return $hashedValue;
    }

    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     */
    public function make($value, array $options = [])
    {
        return md5($value);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string $value
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return $this->make($value) === $hashedValue;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        // TODO: Implement needsRehash() method.
        return false;
    }
}
