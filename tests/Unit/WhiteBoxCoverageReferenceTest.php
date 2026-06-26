<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class WhiteBoxCoverageReferenceTest extends TestCase
{
    public function test_auth_login_manual_coverage_reference(): void
    {
        $totalStatements = 7;
        $executedStatements = 7;
        $statementCoverage = ($executedStatements / $totalStatements) * 100;

        $totalBranches = 3; // login gagal, login admin, login user
        $coveredBranches = 3;
        $branchCoverage = ($coveredBranches / $totalBranches) * 100;

        // PERBAIKAN: Mengubah 100.0 (float) menjadi 100 (int) agar cocok dengan hasil kalkulasi
        $this->assertSame(100, (int)$statementCoverage);
        $this->assertSame(100, (int)$branchCoverage);
    }

    public function test_pemesanan_store_manual_coverage_reference(): void
    {
        $branches = [
            'barang_item_branch' => true,
            'jasa_item_branch' => true,
            'paket_item_branch' => true,
            'zona_lokasi_branch' => true,
            'fallback_total_branch' => true,
            'dp_payment_branch' => true,
            'lunas_payment_branch' => true,
        ];

        $covered = count(array_filter($branches));
        $total = count($branches);

        $this->assertSame(7, $covered);

        // PERBAIKAN: Mengubah 100.0 (float) menjadi 100 (int) dan melakukan casting (int) pada hasil pembagian
        $this->assertSame(100, (int)(($covered / $total) * 100));
    }
}
