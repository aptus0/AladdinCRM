<?php

namespace Database\Seeders\Support;

use App\Enums\OpportunityStage;
use App\Enums\TaskStatus;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Enums\UserRole;

class CrmSeedData
{
    /**
     * @return list<array{name: string, email: string, role: UserRole}>
     */
    public static function users(): array
    {
        return [
            ['name' => 'Samet Admin', 'email' => 'admin@aladdincrm.test', 'role' => UserRole::Admin],
            ['name' => 'Zeynep Sales', 'email' => 'sales@aladdincrm.test', 'role' => UserRole::Staff],
            ['name' => 'Merve Staff', 'email' => 'staff@aladdincrm.test', 'role' => UserRole::Staff],
            ['name' => 'Kerem Support', 'email' => 'support@aladdincrm.test', 'role' => UserRole::Staff],
            ['name' => 'Ece Ops', 'email' => 'ops@aladdincrm.test', 'role' => UserRole::Staff],
        ];
    }

    /**
     * @return list<array{
     *     created_by: string,
     *     name: string,
     *     industry: string,
     *     phone: string,
     *     email: string,
     *     website: string,
     *     address: string,
     *     notes: string
     * }>
     */
    public static function companies(): array
    {
        return [
            [
                'created_by' => 'admin@aladdincrm.test',
                'name' => 'Artemis Dijital Ajans',
                'industry' => 'Pazarlama',
                'phone' => '+90 212 555 10 10',
                'email' => 'info@artemisajans.com',
                'website' => 'https://artemisajans.com',
                'address' => 'Maslak, Istanbul',
                'notes' => 'Aylik performans ve lead yonetimi icin aktif musteri.',
            ],
            [
                'created_by' => 'sales@aladdincrm.test',
                'name' => 'Nova Lojistik',
                'industry' => 'Lojistik',
                'phone' => '+90 216 555 11 11',
                'email' => 'operasyon@novalojistik.com',
                'website' => 'https://novalojistik.com',
                'address' => 'Atasehir, Istanbul',
                'notes' => 'Sik ticket olusturan ve SLA takibi oncelikli hesap.',
            ],
            [
                'created_by' => 'admin@aladdincrm.test',
                'name' => 'Mira Dental Group',
                'industry' => 'Saglik',
                'phone' => '+90 312 555 12 12',
                'email' => 'yonetim@miradental.com',
                'website' => 'https://miradental.com',
                'address' => 'Cankaya, Ankara',
                'notes' => 'Quote sureci hizli, teklif donusleri yuksek.',
            ],
            [
                'created_by' => 'sales@aladdincrm.test',
                'name' => 'Kuzey Yazilim',
                'industry' => 'Yazilim',
                'phone' => '+90 850 555 13 13',
                'email' => 'hello@kuzeyyazilim.com',
                'website' => 'https://kuzeyyazilim.com',
                'address' => 'Bornova, Izmir',
                'notes' => 'Multi-departman kullanim hedefleyen B2B hesap.',
            ],
            [
                'created_by' => 'staff@aladdincrm.test',
                'name' => 'Atlas Danismanlik',
                'industry' => 'Danismanlik',
                'phone' => '+90 216 555 14 14',
                'email' => 'ofis@atlasdanismanlik.com',
                'website' => 'https://atlasdanismanlik.com',
                'address' => 'Kadikoy, Istanbul',
                'notes' => 'Yeni kayit olusumu yuksek, contact yonetimi kritik.',
            ],
            [
                'created_by' => 'ops@aladdincrm.test',
                'name' => 'Rota Turizm',
                'industry' => 'Turizm',
                'phone' => '+90 252 555 15 15',
                'email' => 'crm@rotaturizm.com',
                'website' => 'https://rotaturizm.com',
                'address' => 'Bodrum, Mugla',
                'notes' => 'Destek ve operasyon sureci birlikte ilerliyor.',
            ],
        ];
    }

    /**
     * @return array<string, list<array{
     *     created_by: string,
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     phone: string,
     *     title: string,
     *     notes: string
     * }>>
     */
    public static function contactsByCompany(): array
    {
        return [
            'Artemis Dijital Ajans' => [
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'first_name' => 'Mert',
                    'last_name' => 'Yilmaz',
                    'email' => 'mert@artemisajans.com',
                    'phone' => '+90 532 101 10 10',
                    'title' => 'Growth Lead',
                    'notes' => 'Haftalik pipeline toplantilarina katilir.',
                ],
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'first_name' => 'Ece',
                    'last_name' => 'Demir',
                    'email' => 'ece@artemisajans.com',
                    'phone' => '+90 532 101 10 11',
                    'title' => 'Account Manager',
                    'notes' => 'Quote onay sureci icin birincil kontak.',
                ],
            ],
            'Nova Lojistik' => [
                [
                    'created_by' => 'support@aladdincrm.test',
                    'first_name' => 'Arda',
                    'last_name' => 'Kaya',
                    'email' => 'arda@novalojistik.com',
                    'phone' => '+90 532 102 11 10',
                    'title' => 'Operasyon Muduru',
                    'notes' => 'Ticket onceliklerini belirleyen yetkili.',
                ],
                [
                    'created_by' => 'support@aladdincrm.test',
                    'first_name' => 'Selin',
                    'last_name' => 'Acar',
                    'email' => 'selin@novalojistik.com',
                    'phone' => '+90 532 102 11 11',
                    'title' => 'Musteri Temsilcisi',
                    'notes' => 'Destek mesajlarini olusturan ana kullanici.',
                ],
            ],
            'Mira Dental Group' => [
                [
                    'created_by' => 'sales@aladdincrm.test',
                    'first_name' => 'Zeynep',
                    'last_name' => 'Aslan',
                    'email' => 'zeynep@miradental.com',
                    'phone' => '+90 532 103 12 10',
                    'title' => 'Klinik Yoneticisi',
                    'notes' => 'PDF teklifleri hizli onaylar.',
                ],
                [
                    'created_by' => 'sales@aladdincrm.test',
                    'first_name' => 'Can',
                    'last_name' => 'Uslu',
                    'email' => 'can@miradental.com',
                    'phone' => '+90 532 103 12 11',
                    'title' => 'Satinalma Uzmani',
                    'notes' => 'Fiyat revizyonlarinda karar verici.',
                ],
            ],
            'Kuzey Yazilim' => [
                [
                    'created_by' => 'ops@aladdincrm.test',
                    'first_name' => 'Burak',
                    'last_name' => 'Kilic',
                    'email' => 'burak@kuzeyyazilim.com',
                    'phone' => '+90 532 104 13 10',
                    'title' => 'CTO',
                    'notes' => 'API ve entegrasyon taleplerini yonetir.',
                ],
                [
                    'created_by' => 'ops@aladdincrm.test',
                    'first_name' => 'Derya',
                    'last_name' => 'Aydin',
                    'email' => 'derya@kuzeyyazilim.com',
                    'phone' => '+90 532 104 13 11',
                    'title' => 'Proje Koordinatoru',
                    'notes' => 'Task takip akisinda birincil kisi.',
                ],
            ],
            'Atlas Danismanlik' => [
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'first_name' => 'Melis',
                    'last_name' => 'Kurt',
                    'email' => 'melis@atlasdanismanlik.com',
                    'phone' => '+90 532 105 14 10',
                    'title' => 'Is Gelistirme Uzmani',
                    'notes' => 'Pipeline degisimlerinde aktif.',
                ],
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'first_name' => 'Baris',
                    'last_name' => 'Sahin',
                    'email' => 'baris@atlasdanismanlik.com',
                    'phone' => '+90 532 105 14 11',
                    'title' => 'Mali Isler',
                    'notes' => 'Quote odeme maddelerini onaylar.',
                ],
            ],
            'Rota Turizm' => [
                [
                    'created_by' => 'support@aladdincrm.test',
                    'first_name' => 'Asli',
                    'last_name' => 'Turan',
                    'email' => 'asli@rotaturizm.com',
                    'phone' => '+90 532 106 15 10',
                    'title' => 'Operasyon Sorumlusu',
                    'notes' => 'Yuksek sezon ticket yogunlugu vardir.',
                ],
                [
                    'created_by' => 'support@aladdincrm.test',
                    'first_name' => 'Onur',
                    'last_name' => 'Erdem',
                    'email' => 'onur@rotaturizm.com',
                    'phone' => '+90 532 106 15 11',
                    'title' => 'Satis Sorumlusu',
                    'notes' => 'Firsat kapanis tarihlerini takip eder.',
                ],
            ],
        ];
    }

    /**
     * @return array<string, list<array{
     *     created_by: string,
     *     title: string,
     *     stage: OpportunityStage,
     *     amount: int,
     *     close_in_days: int,
     *     notes: string
     * }>>
     */
    public static function opportunitiesByCompany(): array
    {
        return [
            'Artemis Dijital Ajans' => [
                [
                    'created_by' => 'sales@aladdincrm.test',
                    'title' => 'Q2 Performans Paketi',
                    'stage' => OpportunityStage::Proposal,
                    'amount' => 240000,
                    'close_in_days' => 18,
                    'notes' => 'Son teklif revizyonu bekleniyor.',
                ],
                [
                    'created_by' => 'sales@aladdincrm.test',
                    'title' => 'SEO + CRM Entegrasyon',
                    'stage' => OpportunityStage::Negotiation,
                    'amount' => 175000,
                    'close_in_days' => 26,
                    'notes' => 'Teknik kapsam toplantisi planlandi.',
                ],
            ],
            'Nova Lojistik' => [
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'title' => 'Filo Takip Lisans Gecisi',
                    'stage' => OpportunityStage::Qualified,
                    'amount' => 98000,
                    'close_in_days' => 14,
                    'notes' => 'Demo sonrasi maliyet calismasi istendi.',
                ],
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'title' => 'Destek SLA Paketi',
                    'stage' => OpportunityStage::Lead,
                    'amount' => 56000,
                    'close_in_days' => 35,
                    'notes' => 'Ilk gorusme tamamlandi.',
                ],
            ],
            'Mira Dental Group' => [
                [
                    'created_by' => 'sales@aladdincrm.test',
                    'title' => 'Merkezi Randevu Operasyon',
                    'stage' => OpportunityStage::Won,
                    'amount' => 320000,
                    'close_in_days' => 7,
                    'notes' => 'Sozlesme imzalandi, onboarding basliyor.',
                ],
                [
                    'created_by' => 'sales@aladdincrm.test',
                    'title' => 'Hasta Takip Modulu',
                    'stage' => OpportunityStage::Proposal,
                    'amount' => 129000,
                    'close_in_days' => 22,
                    'notes' => 'Ek moduller icin kapsam netlesiyor.',
                ],
            ],
            'Kuzey Yazilim' => [
                [
                    'created_by' => 'admin@aladdincrm.test',
                    'title' => 'Bayi Portal CRM Entegrasyonu',
                    'stage' => OpportunityStage::Negotiation,
                    'amount' => 285000,
                    'close_in_days' => 31,
                    'notes' => 'Guvenlik ve auth mimarisi gorusuluyor.',
                ],
                [
                    'created_by' => 'admin@aladdincrm.test',
                    'title' => 'Destek Merkezi V2',
                    'stage' => OpportunityStage::Lost,
                    'amount' => 91000,
                    'close_in_days' => 10,
                    'notes' => 'Butce sebebiyle bir sonraki ceyrege ertelendi.',
                ],
            ],
            'Atlas Danismanlik' => [
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'title' => 'Kurumsal Raporlama Paketi',
                    'stage' => OpportunityStage::Qualified,
                    'amount' => 112000,
                    'close_in_days' => 19,
                    'notes' => 'Rapor dashboard beklentisi net.',
                ],
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'title' => 'Coklu Subeler CRM Altyapisi',
                    'stage' => OpportunityStage::Lead,
                    'amount' => 149000,
                    'close_in_days' => 38,
                    'notes' => 'Ihtiyac analizi asamasinda.',
                ],
            ],
            'Rota Turizm' => [
                [
                    'created_by' => 'ops@aladdincrm.test',
                    'title' => 'Sezonluk Satis Operasyon Panosu',
                    'stage' => OpportunityStage::Qualified,
                    'amount' => 134000,
                    'close_in_days' => 20,
                    'notes' => 'Yaz sezonu oncesi canliya alinacak.',
                ],
                [
                    'created_by' => 'ops@aladdincrm.test',
                    'title' => 'Call Center Ticket Otomasyonu',
                    'stage' => OpportunityStage::Proposal,
                    'amount' => 164000,
                    'close_in_days' => 24,
                    'notes' => 'Ticket SLA tanimlari tamamlaniyor.',
                ],
            ],
        ];
    }

    /**
     * @return list<array{
     *     company: string,
     *     created_by: string,
     *     assignee: string,
     *     status: TaskStatus,
     *     due_in_days: int,
     *     title: string,
     *     description: string
     * }>
     */
    public static function extraTasks(): array
    {
        return [
            [
                'company' => 'Artemis Dijital Ajans',
                'created_by' => 'staff@aladdincrm.test',
                'assignee' => 'sales@aladdincrm.test',
                'status' => TaskStatus::Todo,
                'due_in_days' => 2,
                'title' => 'Aylik performans toplanti notlarini hazirla',
                'description' => 'KPI ozeti ve sonraki sprint hedeflerini hazirla.',
            ],
            [
                'company' => 'Nova Lojistik',
                'created_by' => 'support@aladdincrm.test',
                'assignee' => 'ops@aladdincrm.test',
                'status' => TaskStatus::Doing,
                'due_in_days' => 3,
                'title' => 'SLA ihlal raporunu guncelle',
                'description' => 'Son 30 gun ticket cevap sureleri raporlanacak.',
            ],
            [
                'company' => 'Mira Dental Group',
                'created_by' => 'sales@aladdincrm.test',
                'assignee' => 'staff@aladdincrm.test',
                'status' => TaskStatus::Done,
                'due_in_days' => -1,
                'title' => 'Onboarding egitimini tamamla',
                'description' => 'Admin ve staff kullanicilari icin egitim tamamlandi.',
            ],
        ];
    }

    /**
     * @return array<string, list<array{
     *     created_by: string,
     *     assigned_to: string,
     *     subject: string,
     *     priority: TicketPriority,
     *     status: TicketStatus,
     *     contact_email: string,
     *     messages: list<array{user: string, message: string, is_internal: bool}>
     * }>>
     */
    public static function ticketsByCompany(): array
    {
        return [
            'Artemis Dijital Ajans' => [
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'assigned_to' => 'support@aladdincrm.test',
                    'subject' => 'PDF olusturma sonrasi mail baglantisi acilmiyor',
                    'priority' => TicketPriority::High,
                    'status' => TicketStatus::Open,
                    'contact_email' => 'ece@artemisajans.com',
                    'messages' => [
                        [
                            'user' => 'staff@aladdincrm.test',
                            'message' => 'Musteri PDF baglantisinin 404 dondugunu iletti.',
                            'is_internal' => false,
                        ],
                        [
                            'user' => 'support@aladdincrm.test',
                            'message' => 'URL token suresi uzatildi, tekrar test ediliyor.',
                            'is_internal' => true,
                        ],
                    ],
                ],
            ],
            'Nova Lojistik' => [
                [
                    'created_by' => 'support@aladdincrm.test',
                    'assigned_to' => 'ops@aladdincrm.test',
                    'subject' => 'Ticket filtre ekraninda yavaslama',
                    'priority' => TicketPriority::Urgent,
                    'status' => TicketStatus::Waiting,
                    'contact_email' => 'arda@novalojistik.com',
                    'messages' => [
                        [
                            'user' => 'support@aladdincrm.test',
                            'message' => 'Yuksek kayitta filtre sorgusu 3 sn uzeri suruyor.',
                            'is_internal' => false,
                        ],
                        [
                            'user' => 'ops@aladdincrm.test',
                            'message' => 'Index eklemesi planlandi, release penceresi bekleniyor.',
                            'is_internal' => true,
                        ],
                    ],
                ],
            ],
            'Mira Dental Group' => [
                [
                    'created_by' => 'sales@aladdincrm.test',
                    'assigned_to' => 'support@aladdincrm.test',
                    'subject' => 'Yeni quote kalemlerinde KDV varsayimi',
                    'priority' => TicketPriority::Medium,
                    'status' => TicketStatus::Closed,
                    'contact_email' => 'can@miradental.com',
                    'messages' => [
                        [
                            'user' => 'sales@aladdincrm.test',
                            'message' => 'KDV oranini kalem bazli degistirmek istiyorlar.',
                            'is_internal' => false,
                        ],
                        [
                            'user' => 'support@aladdincrm.test',
                            'message' => 'Ozellik aktif edildi ve dogrulama yapildi.',
                            'is_internal' => false,
                        ],
                    ],
                ],
            ],
            'Kuzey Yazilim' => [
                [
                    'created_by' => 'admin@aladdincrm.test',
                    'assigned_to' => 'support@aladdincrm.test',
                    'subject' => 'API rate limit loglari eksik gorunuyor',
                    'priority' => TicketPriority::High,
                    'status' => TicketStatus::Open,
                    'contact_email' => 'burak@kuzeyyazilim.com',
                    'messages' => [
                        [
                            'user' => 'admin@aladdincrm.test',
                            'message' => 'Rate limit asimlarinda audit log kaydi bekleniyor.',
                            'is_internal' => false,
                        ],
                    ],
                ],
            ],
            'Atlas Danismanlik' => [
                [
                    'created_by' => 'staff@aladdincrm.test',
                    'assigned_to' => 'ops@aladdincrm.test',
                    'subject' => 'Dashboard grafiklerinde para birimi etiketi',
                    'priority' => TicketPriority::Low,
                    'status' => TicketStatus::Waiting,
                    'contact_email' => 'melis@atlasdanismanlik.com',
                    'messages' => [
                        [
                            'user' => 'staff@aladdincrm.test',
                            'message' => 'USD ve EUR ayri etiketle gosterilmeli.',
                            'is_internal' => false,
                        ],
                    ],
                ],
            ],
            'Rota Turizm' => [
                [
                    'created_by' => 'ops@aladdincrm.test',
                    'assigned_to' => 'support@aladdincrm.test',
                    'subject' => 'Toplu ticket import talebi',
                    'priority' => TicketPriority::Medium,
                    'status' => TicketStatus::Open,
                    'contact_email' => 'asli@rotaturizm.com',
                    'messages' => [
                        [
                            'user' => 'ops@aladdincrm.test',
                            'message' => 'Eski sistemden ticket aktarimi icin CSV formati soruluyor.',
                            'is_internal' => false,
                        ],
                    ],
                ],
            ],
        ];
    }
}
