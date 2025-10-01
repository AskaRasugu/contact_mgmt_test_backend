<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Group;

class ContactGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create groups
        $groups = [
            [
                'name' => 'Family',
                'description' => 'Family members and relatives',
                'color' => '#EF4444',
            ],
            [
                'name' => 'Friends',
                'description' => 'Close friends and acquaintances',
                'color' => '#10B981',
            ],
            [
                'name' => 'Work',
                'description' => 'Colleagues and business contacts',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Clients',
                'description' => 'Business clients and customers',
                'color' => '#8B5CF6',
            ],
        ];

        foreach ($groups as $groupData) {
            Group::create($groupData);
        }

        // Create contacts
        $contacts = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1-555-0123',
                'address' => '123 Main St, Anytown, USA',
                'birthday' => '1985-06-15',
                'notes' => 'Software developer, loves hiking',
                'group_ids' => [1, 2], // Family and Friends
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1-555-0456',
                'address' => '456 Oak Ave, Somewhere, USA',
                'birthday' => '1990-03-22',
                'notes' => 'Marketing manager, coffee enthusiast',
                'group_ids' => [2, 3], // Friends and Work
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike.johnson@company.com',
                'phone' => '+1-555-0789',
                'address' => '789 Pine St, Business City, USA',
                'birthday' => '1978-11-08',
                'notes' => 'CEO of TechCorp',
                'group_ids' => [3, 4], // Work and Clients
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'email' => 'sarah.wilson@example.com',
                'phone' => '+1-555-0321',
                'address' => '321 Elm St, Hometown, USA',
                'birthday' => '1992-09-14',
                'notes' => 'Graphic designer, art lover',
                'group_ids' => [1, 2], // Family and Friends
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@client.com',
                'phone' => '+1-555-0654',
                'address' => '654 Maple Dr, Client City, USA',
                'birthday' => '1980-12-03',
                'notes' => 'Important client, prefers email communication',
                'group_ids' => [4], // Clients only
            ],
        ];

        foreach ($contacts as $contactData) {
            $groupIds = $contactData['group_ids'];
            unset($contactData['group_ids']);
            
            $contact = Contact::create($contactData);
            $contact->groups()->attach($groupIds);
        }
    }
}

