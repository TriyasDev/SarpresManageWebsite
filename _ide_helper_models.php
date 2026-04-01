<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Barang
 *
 * @property int $id_barang
 * @property string $nama_barang
 * @property string $kategori
 * @property string $kondisi
 * @property int $jumlah_total
 * @property int $jumlah_tersedia
 * @property string|null $deskripsi
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailPeminjaman> $detailPeminjamans
 * @property-read int|null $detail_peminjamans_count
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereIdBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereJumlahTersedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereJumlahTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang withoutTrashed()
 */
	class Barang extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DetailPeminjaman
 *
 * @property int $id_detail
 * @property int $id_peminjaman
 * @property int $id_barang
 * @property int $jumlah
 * @property string|null $kondisi_pinjam
 * @property string|null $kondisi_kembali
 * @property string|null $keterangan
 * @property-read \App\Models\Barang $barang
 * @property-read \App\Models\Peminjaman $peminjaman
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman query()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman whereIdBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman whereIdDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman whereIdPeminjaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman whereKondisiKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman whereKondisiPinjam($value)
 */
	class DetailPeminjaman extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Laporan
 *
 * @property int $id_laporan
 * @property int $id_peminjaman
 * @property int $id_admin
 * @property string $jenis_laporan
 * @property string $kondisi_barang
 * @property \Illuminate\Support\Carbon|null $tanggal_dipinjam
 * @property \Illuminate\Support\Carbon|null $tanggal_dikembalikan
 * @property string|null $foto_bukti
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $admin
 * @property-read mixed $badge_jenis
 * @property-read mixed $badge_kondisi
 * @property-read mixed $label_jenis
 * @property-read mixed $label_kondisi
 * @property-read \App\Models\Peminjaman $peminjaman
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereFotoBukti($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereIdAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereIdLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereIdPeminjaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereJenisLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereKondisiBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereTanggalDikembalikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereTanggalDipinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan withoutTrashed()
 */
	class Laporan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Peminjaman
 *
 * @property int $id_peminjaman
 * @property int $id_user
 * @property int|null $id_admin
 * @property \Illuminate\Support\Carbon $tanggal_pinjam
 * @property \Illuminate\Support\Carbon|null $tanggal_kembali
 * @property \Illuminate\Support\Carbon|null $tanggal_kembali_aktual
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $rejected_at
 * @property string|null $catatan
 * @property int|null $disetujui_oleh
 * @property string|null $return_condition
 * @property bool $is_late
 * @property int $point_earned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $admin
 * @property-read \App\Models\User|null $approver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailPeminjaman> $detailPeminjaman
 * @property-read int|null $detail_peminjaman_count
 * @property-read string $badge_return_condition
 * @property-read string $badge_status
 * @property-read int $duration_days
 * @property-read mixed $first_detail
 * @property-read string $icon_status
 * @property-read bool $is_due_soon
 * @property-read bool $is_overdue
 * @property-read mixed $is_pending
 * @property-read string $label_return_condition
 * @property-read string $label_status
 * @property-read int $remaining_days
 * @property-read int $total_items
 * @property-read \App\Models\Laporan|null $laporan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PointLog> $pointLogs
 * @property-read int|null $point_logs_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman query()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereDisetujuiOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereIdAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereIdPeminjaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereIsLate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman wherePointEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereRejectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereReturnCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereTanggalKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereTanggalKembaliAktual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereTanggalPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman whereUpdatedAt($value)
 */
	class Peminjaman extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PointLog
 *
 * @property int $id_log
 * @property int $id_user
 * @property int|null $id_peminjaman
 * @property int $change
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $change_color
 * @property-read mixed $change_label
 * @property-read mixed $reason_label
 * @property-read \App\Models\Peminjaman|null $peminjaman
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog whereChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog whereIdLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog whereIdPeminjaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointLog whereUpdatedAt($value)
 */
	class PointLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id_user
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $no_telpon
 * @property string $role
 * @property string|null $nama
 * @property string|null $kelas
 * @property string|null $nipd
 * @property string|null $alamat
 * @property \Illuminate\Support\Carbon|null $tanggal_lahir
 * @property string|null $jenis_kelamin
 * @property int|null $points
 * @property string|null $tier
 * @property bool $is_banned
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Peminjaman> $approvedPeminjamans
 * @property-read int|null $approved_peminjamans_count
 * @property-read int $active_borrows_count
 * @property-read string|null $formatted_phone
 * @property-read string $full_name
 * @property-read int $late_return_count
 * @property-read int $max_days
 * @property-read int $max_electronics
 * @property-read int $max_items
 * @property-read float $on_time_percentage
 * @property-read int $overdue_items_count
 * @property-read int $pending_requests_count
 * @property-read string $role_badge
 * @property-read string $role_name
 * @property-read string $tier_color
 * @property-read string $tier_label
 * @property-read int $total_borrowed
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Laporan> $laporans
 * @property-read int|null $laporans_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Peminjaman> $peminjamans
 * @property-read int|null $peminjamans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PointLog> $pointLogs
 * @property-read int|null $point_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Peminjaman> $processedPeminjamans
 * @property-read int|null $processed_peminjamans_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNipd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNoTelpon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

