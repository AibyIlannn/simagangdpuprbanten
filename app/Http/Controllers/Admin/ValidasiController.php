<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ValidasiController extends Controller
{
    /**
     * Tampilkan halaman validasi
     */
    public function index()
    {
        $pengajuanList = PengajuanMagang::with(['kordinator', 'pesertaMagang'])
            ->whereIn('status', ['pending', 'reject'])
            ->latest()
            ->get();
        
        return view('dashboard.admin.validasi', compact('pengajuanList'));
    }

    /**
     * Approve pengajuan magang
     */
    public function approve(Request $request)
    {
        try {
            $pengajuan = PengajuanMagang::findOrFail($request->pengajuan_id);
            
            // Get current admin info
            $adminName = Auth::guard('superadmin')->check() 
                ? Auth::guard('superadmin')->user()->nama_lengkap 
                : Auth::guard('admin')->user()->nama_lengkap;
            
            $adminRole = Auth::guard('superadmin')->check() ? 'superadmin' : 'admin';
            $adminId = Auth::guard('superadmin')->check() 
                ? Auth::guard('superadmin')->id() 
                : Auth::guard('admin')->id();

            // Update status
            $pengajuan->update([
                'status' => 'acc',
                'keterangan' => null, // Clear previous rejection reason
                'approved_at' => now(),
                'approved_by_id' => $adminId,
                'approved_by_role' => $adminRole,
                'approved_by_name' => $adminName,
            ]);

            return redirect()
                ->route('dashboard.admin.validasi')
                ->with('success', "Pengajuan dari {$pengajuan->kordinator->nama_sekolah} berhasil disetujui!");
                
        } catch (\Exception $e) {
            return redirect()
                ->route('dashboard.admin.validasi')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reject pengajuan magang
     */
    public function reject(Request $request)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_magang,id',
            'keterangan' => 'required|string|min:10|max:500',
        ], [
            'keterangan.required' => 'Alasan penolakan wajib diisi',
            'keterangan.min' => 'Alasan penolakan minimal 10 karakter',
            'keterangan.max' => 'Alasan penolakan maksimal 500 karakter',
        ]);

        try {
            $pengajuan = PengajuanMagang::findOrFail($request->pengajuan_id);
            
            // Get current admin info
            $adminName = Auth::guard('superadmin')->check() 
                ? Auth::guard('superadmin')->user()->nama_lengkap 
                : Auth::guard('admin')->user()->nama_lengkap;
            
            $adminRole = Auth::guard('superadmin')->check() ? 'superadmin' : 'admin';
            $adminId = Auth::guard('superadmin')->check() 
                ? Auth::guard('superadmin')->id() 
                : Auth::guard('admin')->id();

            // Update status
            $pengajuan->update([
                'status' => 'reject',
                'keterangan' => $request->keterangan,
                'rejected_at' => now(),
                'rejected_by_id' => $adminId,
                'rejected_by_role' => $adminRole,
                'rejected_by_name' => $adminName,
            ]);

            return redirect()
                ->route('dashboard.admin.validasi')
                ->with('success', "Pengajuan dari {$pengajuan->kordinator->nama_sekolah} berhasil ditolak");
                
        } catch (\Exception $e) {
            return redirect()
                ->route('dashboard.admin.validasi')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk action untuk approve/reject multiple pengajuan
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:pengajuan_magang,id',
            'keterangan' => 'required_if:action,reject|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $adminName = Auth::guard('superadmin')->check() 
                ? Auth::guard('superadmin')->user()->nama_lengkap 
                : Auth::guard('admin')->user()->nama_lengkap;
            
            $adminRole = Auth::guard('superadmin')->check() ? 'superadmin' : 'admin';
            $adminId = Auth::guard('superadmin')->check() 
                ? Auth::guard('superadmin')->id() 
                : Auth::guard('admin')->id();

            if ($request->action === 'approve') {
                PengajuanMagang::whereIn('id', $request->ids)->update([
                    'status' => 'acc',
                    'keterangan' => null,
                    'approved_at' => now(),
                    'approved_by_id' => $adminId,
                    'approved_by_role' => $adminRole,
                    'approved_by_name' => $adminName,
                ]);
                
                $message = count($request->ids) . ' pengajuan berhasil disetujui';
            } else {
                PengajuanMagang::whereIn('id', $request->ids)->update([
                    'status' => 'reject',
                    'keterangan' => $request->keterangan,
                    'rejected_at' => now(),
                    'rejected_by_id' => $adminId,
                    'rejected_by_role' => $adminRole,
                    'rejected_by_name' => $adminName,
                ]);
                
                $message = count($request->ids) . ' pengajuan berhasil ditolak';
            }

            DB::commit();

            return redirect()
                ->route('dashboard.admin.validasi')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->route('dashboard.admin.validasi')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}