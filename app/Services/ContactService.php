<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Image;

class ContactService
{

    /**
     * instantiate Contact
     * @param Contact $contact
     */
    public function __construct
    (
        private Contact $contact,
        private Image $image,
    )
    {
        
    }

    /**
     * store contact
     *
     * @param array $data
     * @return void
     */
    public function store(array $data)
    {
        $contact = $this->contact->create($data);
        if(isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('contacts');
            $contact->image()->save(
                $this->image->make(['path' => $path])
            );
        }
        return $contact;
    }
}
