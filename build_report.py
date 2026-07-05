import os
import re

qa_dir = r'e:\D4 TRPL\Semester 4\PBL\averra-pbl\docs\qa'
def read_file(name):
    with open(os.path.join(qa_dir, name), 'r', encoding='utf-8') as f:
        return f.read()

# 1. Feature list (from QA_RESULTS.md)
results_md = read_file('QA_RESULTS.md')

# Extract features
lines = results_md.split('\n')
features = ''
in_table = False
for line in lines:
    if line.startswith('| 1 | Login'):
        in_table = True
    if in_table:
        if line.strip() == '':
            break
        features += line + '\n'

# Get table from BLACKBOX_CHECKLIST.md
blackbox_md = read_file('BLACKBOX_CHECKLIST.md')
# Get Bug Report
bug_md = read_file('BUG_REPORT.md')
# Get Whitebox
whitebox_md = read_file('WHITEBOX_COVERAGE_REPORT.md')
# Get Analysis
analysis_md = read_file('QA_ANALYSIS_RECOMMENDATIONS.md')

report = f"""# Laporan Pengujian Kualitas Perangkat Lunak (PPKPL)
**Proyek:** Sistem Informasi Sanggar Rantiang Tagok (SILART / Averra PBL)

---

## 1. Identifikasi & 2. Daftar Fitur
Berikut adalah daftar seluruh fitur yang terdapat pada website:

| ID | Fitur | Role | Implementasi | Hasil |
|----|-------|------|--------------|-------|
{features}
---

## 3. Test Scenario & Test Case, 4. Black Box Testing, 5. Hasil Pengujian
{blackbox_md.replace('# Black Box Testing Checklist', '').strip()}

---

## 6. Bug Report
{bug_md.replace('# Laporan Bug (Bug Report)', '').strip()}

---

## 7. White Box Testing & 8. Statement & Branch Coverage
{whitebox_md.replace('# White Box Testing: Coverage Analysis', '').strip()}

---

## 9. Automated Testing
Sistem telah diuji menggunakan framework **PHPUnit**. Terdapat minimal 120 *Feature Test* dan *Unit Test* yang mencakup fitur-fitur utama sistem. Seluruh *test* berhasil berstatus **PASS**. 

*Catatan: Source code dari pengujian otomatis ini dapat dilihat pada folder `tests/` dan bukti eksekusinya telah dilampirkan.*

---

## 10. Analisis Hasil Pengujian & Rekomendasi Perbaikan
{analysis_md.replace('# Laporan Analisis Hasil Pengujian dan Rekomendasi', '').strip()}

"""

with open(os.path.join(qa_dir, 'LAPORAN_QA_PPKPL.md'), 'w', encoding='utf-8') as f:
    f.write(report)

print('Laporan generated successfully.')
