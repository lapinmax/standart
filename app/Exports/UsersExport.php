<?php

namespace App\Exports;

use App\Client;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithMultipleSheets, WithEvents {
    use Exportable, RegistersEventListeners;

    private $type;

    public static function afterSheet (AfterSheet $event) {
        $title = is_null($event->getConcernable()->type) ? 'Email' : $event->getConcernable()->type;

        $event->sheet->setTitle($title);
    }

    public function __construct ($type = null) {
        $this->type = $type;
    }

    public function collection () {
        return Client::where('socialType', $this->type)->get();
    }

    public function map ($client): array {
        $data = [
            is_null($client->created_at) ? '-' : $client->created_at->format('d.m.Y H:i:s'),
            $client->email,
            $client->name,
        ];

        if (!is_null($this->type)) {
            $data[] = $client->socialProfileID;
        }

        $data = array_merge($data, [
            $client->type,
            $client->gender,
            is_null($client->birthday) ? '-' : $client->birthday->format('d.m.Y'),
            $client->favoriteColor,
            $client->favoriteNumber,
            $client->sign,
            $client->relationships,
            is_null($client->partner_birthday) ? '-' : $client->partner_birthday->format('d.m.Y'),
            $client->time_birth,
            $client->place_birth,
            $client->three_questions == 0 ? 'False' : 'True',
            $client->five_questions == 0 ? 'False' : 'True',
            $client->ten_questions == 0 ? 'False' : 'True',
        ]);

        $data = array_map(function ($item) {
            return is_null($item) ? '-' : $item;
        }, $data);

        return $data;
    }

    public function headings (): array {
        $headings = ['Registration date', 'E-mail', 'Name'];

        if (!is_null($this->type)) {
            $headings[] = 'Profile ID';
        }

        $headings = array_merge($headings, [
            'Subscription type', 'Gender', 'Birthday', 'Color', 'Number', 'Sign', 'Relationships', 'Partner birthday',
            'Time of birth', 'Place of birth', 'Purchaser 3 questions', 'Purchaser 5 questions',
            'Purchaser 10 questions'
        ]);

        return $headings;
    }

    public function sheets (): array {
        $types = ['FaceBook', 'Google'];

        $sheets = [];

        foreach ($types as $type) {
            $sheets[$type] = new UsersExport($type);
        }

        $sheets['Email'] = new UsersExport();

        return $sheets;
    }
}
