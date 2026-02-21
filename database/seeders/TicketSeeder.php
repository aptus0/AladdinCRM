<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Database\Seeders\Support\CrmSeedData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersByEmail = User::query()->get()->keyBy('email');

        foreach (CrmSeedData::ticketsByCompany() as $companyName => $tickets) {
            $company = Company::query()->where('name', $companyName)->first();

            if (! $company) {
                continue;
            }

            foreach ($tickets as $seedTicket) {
                $creator = $usersByEmail->get($seedTicket['created_by']) ?? $usersByEmail->first();
                $assignee = $usersByEmail->get($seedTicket['assigned_to']);
                $contact = Contact::query()
                    ->where('company_id', $company->id)
                    ->where('email', $seedTicket['contact_email'])
                    ->first();

                if (! $creator) {
                    continue;
                }

                $ticket = Ticket::query()->updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'subject' => $seedTicket['subject'],
                    ],
                    [
                        'contact_id' => $contact?->id,
                        'created_by' => $creator->id,
                        'assigned_to' => $assignee?->id,
                        'priority' => $seedTicket['priority'],
                        'status' => $seedTicket['status'],
                    ],
                );

                foreach ($seedTicket['messages'] as $seedMessage) {
                    $messageUser = $usersByEmail->get($seedMessage['user']) ?? $creator;

                    TicketMessage::query()->updateOrCreate(
                        [
                            'ticket_id' => $ticket->id,
                            'user_id' => $messageUser->id,
                            'message' => $seedMessage['message'],
                        ],
                        [
                            'is_internal' => $seedMessage['is_internal'],
                        ],
                    );
                }
            }
        }
    }
}
