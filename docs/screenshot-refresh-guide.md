# README Screenshot Refresh Guide

Bu rehber, README icindeki ekran goruntulerini guncel tutmak icin standart akis sunar.

## Hedef Dosyalar

README tarafinda kullanilan gorseller:

- `public/images/landing/dashboard-overview.svg`
- `public/images/landing/quotes-pdf.svg`
- `public/images/landing/tasks-kanban.svg`
- `public/images/landing/tickets-support.svg`

## Guncelleme Adimlari

1. Uygulamayi lokal ortamda calistir:

```bash
composer run dev
```

2. Dashboard ve ilgili sekmelere gec:

- Dashboard
- Quotes
- Tasks
- Tickets

3. Her ekrani 1440px genislikte capture al.
4. Gorselleri `public/images/landing/` altinda ayni dosya adlariyla guncelle.
5. Guncel gorsellerin README onizlemesini kontrol et.

## SVG Kullanim Kurali

Bu projede landing/README gorselleri SVG olarak tutulur.
Yeni screenshot eklerken:

- Dosya adlandirmasini tutarli yapin (`kebab-case`)
- `role=\"img\"` ve anlamli `aria-label` ekleyin
- Metinleri proje dili ile tutarli tutun

## Kontrol Listesi

- [ ] Tum hedef dosyalar guncellendi
- [ ] README baglantilari bozulmadi
- [ ] `npm run build` basarili
- [ ] PR aciklamasina once/sonra ekran goruntusu eklendi
