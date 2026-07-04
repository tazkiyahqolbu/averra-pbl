# QA Testing Workflow
## Project: SILART / Averra PBL
Version: 3.0
Author: Zikra Revanzha

---

# 1. Agent Startup Rules

SETIAP AI Agent baru WAJIB:

1. Baca:
   - QA_TESTING_WORKFLOW.md
   - QA_PROGRESS.md
   - QA_RESULTS.md
   - features.md
   - github-actions.md

2. Periksa checkpoint terakhir di QA_PROGRESS.md

3. Jangan ulang tahap yang sudah selesai

4. Lanjutkan dari checkpoint terakhir

Berlaku untuk:
- Antigravity
- Copilot
- Cursor
- Codex
- AI Agent lainnya

---

# 2. Global Rules

1. Analisis HARUS berdasarkan source code aktual.
2. Jangan mengasumsikan fitur.
3. Jangan melewati satu fitur / fungsi pun.
4. Semua output Bahasa Indonesia formal.
5. Semua hasil harus disimpan ke file markdown.
6. Jika context hampir habis → WAJIB handover.

Prioritas:
AKURASI > KELENGKAPAN > KECEPATAN

---

# 3. Prioritas Sumber Analisis

Gunakan sumber berikut secara berurutan:

1. features.md (SUMBER UTAMA)
2. routes/web.php
3. app/Http/Controllers/*
4. resources/views/*
5. database/migrations/*
6. routes/console.php / console command
7. github-actions.md
8. SRS / WBS

Jika ada perbedaan antara features.md dan source code:
- catat discrepancy
- masukkan ke QA_RESULTS.md
- masukkan ke bug report jika perlu

---

# 4. QA File Structure

Root project:

QA_TESTING_WORKFLOW.md
QA_PROGRESS.md
QA_RESULTS.md

---

# 5. Testing Folder Structure

AI Agent WAJIB memastikan struktur berikut tersedia:

tests/
├── Feature/
│   ├── Auth/
│   ├── Booking/
│   ├── Payment/
│   ├── Admin/
│   ├── Scheduler/
│   └── Public/
└── Unit/
    ├── Pricing/
    ├── Penalty/
    ├── Validation/
    └── Services/

Jika folder belum ada:
AI Agent wajib membuatnya.

---

# 6. Status Testing

Gunakan 3 status:

✅ Berhasil  
❌ Gagal (Bug / Error)  
⏳ Belum Implementasi / Parsial

JANGAN gunakan hanya 2 status.

---

# 7. Naming Convention

Nama file test dan class test gunakan Bahasa Inggris sesuai standar Laravel/PHPUnit.

Contoh:
- LoginTest.php
- BookingTest.php
- PaymentTest.php

Namun seluruh:
- laporan testing
- bug report
- output status
- pesan PASS/FAIL

WAJIB menggunakan Bahasa Indonesia.

---

# 8. Progress Tracking

- [ ] Tahap 0
- [ ] Tahap 1
- [ ] Tahap 2
- [ ] Tahap 3
- [ ] Tahap 4
- [ ] Tahap 5
- [ ] Tahap 6
- [ ] Tahap 7

---

# 9. Tahap 0 — Initial Setup & Analysis

WAJIB dikerjakan pertama.

Langkah:
1. Baca semua file QA markdown
2. Scan seluruh source project
3. Buat struktur folder testing
4. Hapus file test bawaan Laravel jika perlu:
   - tests/Feature/ExampleTest.php
   - tests/Unit/ExampleTest.php

JANGAN hapus:
- tests/TestCase.php

Output:
- Struktur project
- Modul utama
- Risiko awal

STOP

---

# 10. Tahap 1 — Feature Inventory

Identifikasi seluruh fitur:

Role:
- Guest
- User
- Admin
- Scheduler/System

Cakup:
- route
- command scheduler
- business automation
- background process

Output tabel:

| ID | Fitur | Role | Implementasi |
|----|------|------|--------------|

Implementasi:
- Lengkap
- Parsial
- Belum Ada

STOP

---

# 11. Tahap 2 — Test Scenario

Untuk setiap fitur buat scenario:

Wajib:
- Happy Path
- Invalid Input
- Empty Input
- Boundary
- Unauthorized
- Business Rule Violation

Output:

| ID Test | Fitur | Scenario | Jenis |

Jenis:
- Positive
- Negative
- Validation
- Security
- Boundary

STOP

---

# 12. Tahap 3 — Detailed Test Case

Format:

ID Test:
Nama Fitur:
Scenario:
Precondition:
Steps:
Test Data:
Expected Result:

Wajib uji:
- required
- unique
- nullable
- min/max
- FK
- upload validation
- authorization
- business logic
- scheduler logic

STOP

---

# 13. Tahap 4 — Black Box Execution

Output:

| ID Test | Expected | Actual | Status |

Status:
- ✅ Berhasil
- ❌ Gagal
- ⏳ Belum Implementasi

Jika bug ditemukan:
langsung buat bug report

STOP

---

# 14. Tahap 5 — Bug Report

Format:

Bug ID:
Module:
Severity:
Priority:
Description:
Steps:
Expected:
Actual:
Root Cause:
Recommendation:

Severity:
- Low
- Medium
- High
- Critical

Priority:
- P1
- P2
- P3

STOP

---

# 15. Tahap 6 — White Box Testing

Pilih fungsi paling kompleks.

Prioritas:
1. Pemesanan
2. Pembayaran
3. Login
4. Scheduler command
5. Pengembalian

Lakukan:
1. Pecah statement
2. Pecah branch
3. Buat flow graph
4. Hitung coverage

Rumus:

Statement Coverage =
(executed statement / total statement) × 100%

Branch Coverage =
(executed branch / total branch) × 100%

STOP

---

# 16. Tahap 7 — Automated Testing

AI Agent TIDAK BOLEH hanya menulis code di chat.

WAJIB:
1. Membuat file test langsung di project
2. Menentukan:
   - Feature Test
   - Unit Test
3. Menyimpan ke folder sesuai

Tahap 7 dianggap SELESAI hanya jika:

- Minimal 5 Feature Test file dibuat
- Minimal 2 Unit Test file dibuat
- Semua file berisi test nyata (bukan template)
- php artisan test berhasil dijalankan

Contoh:

tests/Feature/Auth/LoginTest.php
tests/Feature/Auth/RegisterTest.php
tests/Feature/Booking/BookingTest.php
tests/Feature/Payment/PaymentTest.php
tests/Feature/Admin/AdminAuthorizationTest.php
tests/Feature/Scheduler/AutoCancelTest.php

tests/Unit/Pricing/PriceCalculatorTest.php
tests/Unit/Penalty/DendaCalculatorTest.php

Setelah file dibuat:
1. Jalankan test
2. Simpan hasil
3. Update QA_RESULTS.md

Verifikasi:
- Local terminal
- GitHub Actions CI (jika tersedia)

STOP

---

# 17. Screenshot Rules

Black Box:
- before
- after
- validation error
- bug

Automation:
- terminal result
- GitHub Actions result

White Box:
- flow graph
- coverage

---

# 18. Handover Rules

Jika context limit:

WAJIB:
1. Update QA_PROGRESS.md
2. Update QA_RESULTS.md
3. Tulis checkpoint
4. Tulis next action

Format:

Checkpoint terakhir:
Tahap X

Selesai:
- ...

Belum:
- ...

Next Action:
- ...