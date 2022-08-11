<?php

namespace App\Http\Controllers;

use Thenextweb\PassGenerator;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Validator;

class TicketsController extends Controller
{
    public function createEventTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eventName' => 'required|string|min:1|max:50',
            'date' => 'required|date',
            'qrCode' => 'required|string',
            'owner' => 'required|string|max:50'

        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        
        $date = Carbon::parse($request->date);

        $pass = new PassGenerator();

        $pass_definition = [
        "description"       => "Ein Ticket",
        "formatVersion"     => 1,
        "organizationName"  => config('passgenerator.organization_name'),
        "passTypeIdentifier"=> config('passgenerator.type_identifier'),
        "serialNumber"      => Str::uuid(),
        "teamIdentifier"    => config('passgenerator.team_id'),
        "backgroundColor"   => "rgb(255, 125, 0)",
        "barcodes" => [
            [
                "message"   => $request->qrCode,
                "format"    => "PKBarcodeFormatQR",
                "altText"   => $request->owner,
                "messageEncoding"=> "utf-8",
            ]
        ],
        "eventTicket" => [
            "headerFields" => [
                [
                    "key" => "eventName",
                    "label" => "EVENT",
                    "value" => $request->eventName
                ]
            ],
            "primaryFields" => [
                [
                    "key" => "owner",
                    "label" => "TICKET-INHABER",
                    "value" => $request->owner
                ]
            ],
            "secondaryFields" => [
                [
                    "key" => "date",
                    "label" => "DATUM",
                    "value" =>  $date->format("d.m.Y")
                ],

            ],
            "auxiliaryFields" => [
                [
                    "key" => "begin",
                    "label" => "BEGINN",
                    "value" => $date->format('H:i')
                ],
                [
                    "key" => "entry",
                    "label" => "EINLASS",
                    "value" => $date->sub(30,'minute')->format('H:i')
                ]
            ]
        ],
];

        $pass->setPassDefinition($pass_definition);
        $pass->addAsset(base_path('resources/assets/wallet/icon.png'));
        $pass->addAsset(base_path('resources/assets/wallet/logo.png'));

        $pkpass = $pass->create();

        return new Response($pkpass, 200, [
            'Content-Transfer-Encoding' => 'binary',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="pass.pkpass"',
            'Content-Type' => PassGenerator::getPassMimeType(),
            'Pragma' => 'no-cache',
        ]);
    }
}
