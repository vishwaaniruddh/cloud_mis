<?php

namespace Razorpay\Api;

class Contact extends Entity
{
    public function create($attributes = [])
    {
        return $this->request('POST', 'contacts', $attributes);
    }
}
