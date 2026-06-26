<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class AdminAccessAndPreviewFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_guest_is_redirected_from_protected_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_user_without_admin_role_cannot_access_admin_dashboard(): void
    {
        $user = $this->makeUser();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_admin_preview_pages_that_exist_can_be_opened(): void
    {
        $routes = [
            'admin.barang.index',
            'admin.barang.create',
            'admin.barang.edit',
            'admin.kategori-barang.index',
            'admin.kategori-jasa.index',
            'admin.pengembalian.index',
            'admin.pengembalian.show',
            'admin.laporan.index',
            'admin.galeri.index',
            'admin.galeri.create',
            'admin.testimoni.index',
            'admin.zona-lokasi.index',
            'admin.blokir-tanggal.index',
            'admin.akun.index',
        ];

        foreach ($routes as $routeName) {
            $this->get(route($routeName))->assertOk();
        }
    }
}
