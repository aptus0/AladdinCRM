# Alladdin CRM Issue Backlog

Bu dokuman, maintainer tarafinda acilabilecek hazir issue havuzudur.
Issue acarken ilgili label'lari ekleyin:

- `good first issue`
- `help wanted`
- `priority:low|medium|high`
- module gore `ui`, `backend`, `api`, `auth`, `documentation`, `testing`

## 1) Dashboard Empty States Polish

- Labels: `good first issue`, `help wanted`, `ui`, `priority:medium`
- Summary: Dashboard kartlarinda veri olmadiginda gorunen metinleri daha anlamli ve aksiyon odakli hale getir.
- Acceptance:
  - [ ] Bos durum metinleri Turkce ve anlasilir
  - [ ] En az bir CTA (or. "Sirket Ekle")
  - [ ] `npm run check` ve `npm run build` basarili

## 2) Company Search Debounce

- Labels: `good first issue`, `help wanted`, `ui`, `api`, `priority:medium`
- Summary: Sirket arama kutusunda istemci tarafi debounce ekle (300ms).
- Acceptance:
  - [ ] Her tus vurusunda API cagrisi yapilmaz
  - [ ] Son query sonucu dogru render edilir
  - [ ] Mevcut listeleme bozulmaz

## 3) Contact Form Validation Message Cleanup

- Labels: `good first issue`, `help wanted`, `backend`, `ui`, `priority:low`
- Summary: Contact create/update validation mesajlarini standartlastir.
- Acceptance:
  - [ ] FormRequest mesajlari acik ve tutarli
  - [ ] Frontend'de hata metni alan bazli gorunur
  - [ ] Existing CRUD akisi korunur

## 4) Opportunity Stage Badge Colors

- Labels: `good first issue`, `help wanted`, `ui`, `priority:low`
- Summary: Opportunity stage degerleri icin tutarli rozet renkleri uygula.
- Acceptance:
  - [ ] Tum stage'ler icin tek map kullanilir
  - [ ] Light/dark mode okunabilirlik korunur
  - [ ] Dashboard ve liste ekraninda ayni renkler gorunur

## 5) Quote Totals Unit Tests

- Labels: `good first issue`, `help wanted`, `testing`, `backend`, `priority:high`
- Summary: Quote total hesaplarina unit/feature test ekle.
- Acceptance:
  - [ ] KDV ve iskonto hesaplari test edilir
  - [ ] Edge case (0 adet, 0 fiyat, farkli para birimi) eklenir
  - [ ] Testler CI'da gecer

## 6) Ticket List Quick Filters

- Labels: `good first issue`, `help wanted`, `ui`, `api`, `priority:medium`
- Summary: Ticket listesinde hizli filtre chip'leri ekle (`open`, `waiting`, `closed`).
- Acceptance:
  - [ ] Tek tikla filtre degisir
  - [ ] Query param URL'e yazilir
  - [ ] Sayfa yenilenmeden liste guncellenir

## 7) Task Kanban Keyboard Accessibility

- Labels: `good first issue`, `help wanted`, `ui`, `testing`, `priority:high`
- Summary: Kanban kartlari icin temel klavye erisilebilirligi ekle.
- Acceptance:
  - [ ] Kart focus alabilir
  - [ ] Screen reader icin anlamli aria etiketleri
  - [ ] Drag-drop olmadiginda fallback akis var

## 8) API Error Envelope Standard

- Labels: `good first issue`, `help wanted`, `api`, `backend`, `priority:medium`
- Summary: API hata donuslerini ortak bir yapiya cek.
- Acceptance:
  - [ ] `message`, `errors`, `code` alanlari standardize edilir
  - [ ] En az 3 endpoint'te ayni format gorulur
  - [ ] Frontend hata gostermesi bozulmaz

## 9) README Screenshots Refresh Script

- Labels: `good first issue`, `help wanted`, `documentation`, `priority:low`
- Summary: README screenshot guncelleme adimlarini docs'a scriptli sekilde ekle.
- Acceptance:
  - [ ] `docs/` altinda kisa capture rehberi
  - [ ] Kullanilan dosya adlari ve path'ler net
  - [ ] README baglantilari guncel

## 10) Seed Data Consistency Check Command

- Labels: `good first issue`, `help wanted`, `backend`, `testing`, `priority:medium`
- Summary: Seed verisi icin duplicate email ve null kritik alan kontrol komutu ekle.
- Acceptance:
  - [ ] Artisan command eklendi
  - [ ] En az user/company/contact icin kontrol var
  - [ ] Hatali durumda fail exit code doner

## 11) Mobile Sidebar Regression Test

- Labels: `good first issue`, `help wanted`, `ui`, `testing`, `priority:medium`
- Summary: Mobil sidebar ac/kapa davranisina regression testi ekle.
- Acceptance:
  - [ ] Sidebar mobile width ve close interaction test edilir
  - [ ] Collapse/expand davranisi etkilenmez

## 12) System Status Endpoint Docs

- Labels: `good first issue`, `help wanted`, `documentation`, `api`, `priority:low`
- Summary: `/api/system/status` endpoint'inin response semasini dokumante et.
- Acceptance:
  - [ ] Ornek JSON cevap eklendi
  - [ ] Auth ve middleware onkosullari yazildi
  - [ ] README'den baglanti verildi
