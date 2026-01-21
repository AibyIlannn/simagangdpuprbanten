<?php

namespace App\Http\Controllers;

use App\Models\Kordinator;
use App\Models\PengajuanMagang;
use App\Models\PesertaMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('daftar');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'nama_sekolah' => 'required|string|max:255',
            'email' => 'required|email|unique:kordinator,email',
            'nomor_wa' => 'required|string|regex:/^628[0-9]{9,11}$/',
            'password' => 'required|min:8|confirmed',
            'jenis_kegiatan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'jumlah_siswa' => 'required|integer|min:1|max:50',
            'bidang_unit' => 'required|string',
            'dokumen' => 'required|file|mimes:pdf|max:5120',
            'participants' => 'required|array',
            'participants.*.nama_siswa' => 'required|string|max:255',
            'participants.*.nisn' => 'required|string|size:10',
            'participants.*.kelas' => 'required|string|max:50',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'nomor_wa.regex' => 'Nomor WhatsApp harus dimulai dengan 628.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'dokumen.mimes' => 'Dokumen harus berformat PDF.',
            'dokumen.max' => 'Ukuran dokumen maksimal 5MB.',
        ]);

        DB::beginTransaction();

        try {
            // 1. Simpan Kordinator
            $kordinator = Kordinator::create([
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'nama_sekolah' => strtoupper($request->nama_sekolah),
                'email' => $request->email,
                'nomor_wa' => $request->nomor_wa,
                'password' => Hash::make($request->password),
                'role' => 'kordinator_sekolah',
            ]);

            // 2. Upload Dokumen
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                $file = $request->file('dokumen');
                $filename = time() . '_' . $kordinator->id . '_' . $file->getClientOriginalName();
                $dokumenPath = $file->storeAs('dokumen_pengajuan', $filename, 'public');
            }

            // 3. Simpan Pengajuan Magang
            $pengajuan = PengajuanMagang::create([
                'kordinator_id' => $kordinator->id,
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jumlah_siswa' => $request->jumlah_siswa,
                'bidang_unit' => $request->bidang_unit,
                'dokumen_path' => $dokumenPath,
                'status' => 'pending',
            ]);

            // 4. Simpan Peserta Magang
            foreach ($request->participants as $participant) {
                PesertaMagang::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_siswa' => $participant['nama_siswa'],
                    'nisn' => $participant['nisn'],
                    'kelas' => $participant['kelas'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Silakan login dengan akun Anda.',
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}