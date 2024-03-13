<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemService;
use Illuminate\Database\Seeder;
use function Laravel\Prompts\note;

class ItemServiceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'قميص',
                'services' => [
                    1 => 3,
                    2 => 10,
                    3 => 40
                ]
            ],
            [
                'name' => 'بنطلون',
                'services' => [
                    1 => 3,
                    2 => 10,
                    3 => 40
                ]
            ],
            [
                'name' => 'جلباب',
                'services' => [
                    1 => 5,
                    2 => 15
                ]
            ],
            [
                'name' => 'جاكت بدلة',
                'services' => [
                    1 => 7,
                    2 => 25
                ]
            ],
            [
                'name' => 'بدلة 2 قطعه',
                'services' => [
                    1 => 13,
                    2 => 40
                ]
            ],
            [
                'name' => 'بدلة 3 قطعه',
                'services' => [
                    1 => 15,
                    2 => 50
                ]
            ],
            [
                'name' => 'جاكت شتوي',
                'services' => [
                    1 => 7,
                    2 => 25
                ]
            ],
            [
                'name' => 'جاكت جلد',
                'services' => [
                    1 => 15,
                    2 => 30
                ]
            ],
            [
                'name' => 'بلوزة',
                'services' => [
                    1 => 5,
                    2 => 15
                ]
            ],
            [
                'name' => 'عبايه حريمي',
                'services' => [
                    1 => 6,
                    2 => 15
                ]
            ],
            [
                'name' => 'تونك',
                'services' => [
                    1 => 6,
                    2 => 15
                ]
            ],
            [
                'name' => 'تونك 2 قطعه',
                'services' => [
                    1 => 10,
                    2 => 20
                ]
            ],
            [
                'name' => 'تيشرت',
                'services' => [
                    1 => 3,
                    2 => 10,
                    3 => 40
                ]
            ],
            [
                'name' => 'فستان سوارية',
                'services' => [
                    1 => 20,
                    2 => 50
                ]
            ],
            [
                'name' => 'فستان خطوبة',
                'services' => [
                    1 => 25,
                    2 => 60
                ]
            ],
            [
                'name' => 'فستان فرح',
                'services' => [
                    1 => null,
                    2 => null
                ],
                'note' => 'حسب الاتفاق'
            ],
            [
                'name' => 'فستان أتيلية',
                'services' => [
                    1 => null,
                    2 => null
                ],
                'note' => 'حسب الاتفاق'
            ],
            [
                'name' => 'ملاية',
                'services' => [
                    1 => 5,
                    2 => 15
                ]
            ],
            [
                'name' => 'كيس مخدة',
                'services' => [
                    1 => 2,
                    2 => 5
                ]
            ],
            [
                'name' => 'بشكير فوطة',
                'services' => [
                    2 => 5
                ]
            ],
            [
                'name' => 'كوتشي',
                'services' => [
                    2 => 30
                ]
            ],
            [
                'name' => 'عربية اطفال',
                'services' => [
                    2 => 70
                ]
            ],
            [
                'name' => 'الانترية',
                'services' => [
                    4 => null
                ],
                'note' => 'حسب الحجم'
            ],
            [
                'name' => 'الصالون',
                'services' => [
                    4 => null,
                ],
                'note' => 'حسب الحجم'
            ],
            [
                'name' => 'كرسي السفرة',
                'services' => [
                    4 => 30
                ]
            ],
            [
                'name' => 'المرتبة الصغيرة',
                'services' => [
                    4 => 150
                ]
            ],
            [
                'name' => 'المرتبة الكبيرة',
                'services' => [
                    4 => 200
                ]
            ],
            [
                'name' => 'جاكت',
                'services' => [
                    3 => 80,
                ]
            ],
            [
                'name' => 'عباية',
                'services' => [
                    3 => 50
                ]
            ],
            [
                // المتر
                'name' => 'سجاد',
                'services' => [
                    4 => null
                ],
                'note' => 'سعر المتر 10 جنية'
            ],
            [
                'name' => 'جافظه السجاد',
                'services' => [
                    4 => 35
                ]
            ],
            [
                'name' => 'بطانية طبقه',
                'services' => [
                    4 => 35
                ]
            ],
            [
                'name' => 'بطانيه 2 طبقه',
                'services' => [
                    4 => 50
                ]
            ],
            [
                'name' => 'لحاف اطفالي',
                'services' => [
                    4 => 35
                ]
            ],
            [
                'name' => 'لحاف كبير',
                'services' => [
                    4 => 35
                ]
            ],
            [
                'name' => 'كبرتة',
                'services' => [
                    4 => 45
                ]
            ],
            [
                'name' => 'دفاية',
                'services' => [
                    4 => 20
                ]
            ],
            [
                'name' => 'مفرش سرير',
                'services' => [
                    4 => 50
                ]
            ],
            [
                'name' => 'ستارة خفيفة',
                'services' => [
                    4 => 20
                ]
            ],
            [
                'name' => 'ستارة تقيلة',
                'services' => [
                    4 => 50
                ]
            ],
            [
                'name' => 'كفر مرتبة',
                'services' => [
                    4 => 25
                ]
            ],
            [
                'name' => 'مخدة كبيرة',
                'services' => [
                    4 => 30
                ]
            ],
            [
                'name' => 'مخدة صغيرة',
                'services' => [
                    4 => 15
                ]
            ]
        ];

        foreach ($items as $item) {
            $created_item = Item::create(
                [
                    'name' => $item['name']
                ]
            );

            $itemServices = [];
            foreach ($item['services'] as $service_id => $price) {
                $itemServices[] = [
                    'item_id' => $created_item->id,
                    'service_id' => $service_id,
                    'price' => $price,
                    'note' => $item['note'] ?? null
                ];

                // Or
//                $created_item->services()->attach(
//                    $created_item->id,
//                    [
//                        'service_id' => $service_id,
//                        'price' => $price,
//                        'note' => $item['note'] ?? null
//                    ]
//                );
            }
            ItemService::insert($itemServices);
        }
    }
}
