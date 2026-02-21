# Contributing to Alladdin CRM

Katki saglamak istediginiz icin tesekkurler.
Bu dokuman, katkilarin hizli review edilmesi ve stabil release kalitesi icin standartlari tanimlar.

## Development Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
composer run dev
```

## Branch Naming

- `feature/<kisa-aciklama>` (ornek: `feature/quotes-pdf`)
- `fix/<kisa-aciklama>` (ornek: `fix/tasks-order-duplication`)
- `docs/<kisa-aciklama>`
- `chore/<kisa-aciklama>`

## Commit Standard

Conventional Commits kullanin:

- `feat(scope): ...`
- `fix(scope): ...`
- `refactor(scope): ...`
- `test(scope): ...`
- `docs(scope): ...`
- `chore(scope): ...`

Scope ornekleri: `auth`, `companies`, `contacts`, `opportunities`, `quotes`, `tasks`, `tickets`, `ui`, `api`.

## Coding Rules

- Controller katmanini ince tutun, is kurallarini Action/Service katmanina tasiyin.
- Validation icin FormRequest kullanin.
- Yetkilendirme icin Policy kullanin.
- Durum degisikligi ve toplu update gibi noktalarda transaction kullanin.
- Yeni davranis ekliyorsaniz test de ekleyin.

## Before Opening a Pull Request

Asagidaki kontrollerin tumu gecmeli:

```bash
npm run check
npm run build
composer test
```

## Pull Request Rules

- PR aciklamasinda amac, kapsam ve test adimlarini yazin.
- Ekran degisikligi varsa ekran goruntusu/GIF ekleyin.
- Geriye donuk uyumluluk riski varsa acikca belirtin.
- Kucuk ve odakli PR tercih edin.

## Issue Labels

- `bug`: hata
- `enhancement`: iyilestirme/ozellik
- `documentation`: dokumantasyon
- `good first issue`: yeni katilimcilara uygun gorev
- `help wanted`: katkici destegi beklenen gorev

## Security

Guvenlik aciklarini public issue olarak acmayin.
Detaylar icin: [`SECURITY.md`](SECURITY.md)
