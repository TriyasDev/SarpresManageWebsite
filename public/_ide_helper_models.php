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
 * @property string $deskripsi
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereIdBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereJumlahTersedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereJumlahTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Barang extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DetailPeminjaman
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman query()
 * @mixin \Eloquent
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
 * @property string $foto_bukti
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $admin
 * @property-read string $badge_jenis
 * @property-read string $badge_kondisi
 * @property-read string $label_jenis
 * @property-read string $label_kondisi
 * @property-read \App\Models\Peminjaman $peminjam
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
 * @mixin \Eloquent
 */
	class Laporan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Peminjaman
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman query()
 * @mixin \Eloquent
 */
	class Peminjaman extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pengajuan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengajuan query()
 */
	class Pengajuan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id_user
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $no_telpon
 * @property string $role
 * @property string|null $rank
 * @property int|null $point
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNoTelpon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 * @property string|null $nipd
 * @property string|null $alamat
 * @property \Illuminate\Support\Carbon|null $tanggal_lahir
 * @property string|null $jenis_kelamin
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNipd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTanggalLahir($value)
 */
	class User extends \Eloquent {}
}

