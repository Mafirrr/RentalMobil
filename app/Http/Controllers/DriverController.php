<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|max:15|unique:drivers,phone',
            'address'            => 'required|string',
            'license_number'     => 'required|string|max:50|unique:drivers,license_number',
            'license_type'       => 'required|in:A,B1,B2,C,Internasional',
            'license_expired'    => 'required|date',
            'avatar_path'        => 'nullable|image|mimes:jpeg,png,jpg',
            'license_image_path' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);
        DB::beginTransaction();

        try {
            $avatarFile = $request->file('avatar_path');
            $licenseFile = $request->file('license_image_path');

            unset($validated['avatar_path'], $validated['license_image_path']);

            $driver = Driver::create($validated);

            $uploadedDriverFiles = [];
            $folderPath = 'drivers/' . $driver->id;
            if ($avatarFile) {
                $extension = $avatarFile->getClientOriginalExtension();
                $avatarName = 'foto_profil.' . $extension;

                $path = Storage::disk('supabase')->putFileAs($folderPath, $avatarFile, $avatarName);

                $s3Url = Storage::disk('supabase')->url($path);
                $uploadedDriverFiles['avatar_path'] = str_replace(
                    '.storage.supabase.co/storage/v1/s3/',
                    '.supabase.co/storage/v1/object/public/',
                    $s3Url
                );
            }

            if ($licenseFile) {
                $extension = $licenseFile->getClientOriginalExtension();
                $licenseName = 'foto_sim.' . $extension;

                $path = Storage::disk('supabase')->putFileAs($folderPath, $licenseFile, $licenseName);

                $s3Url = Storage::disk('supabase')->url($path);
                $uploadedDriverFiles['license_image_path'] = str_replace(
                    '.storage.supabase.co/storage/v1/s3/',
                    '.supabase.co/storage/v1/object/public/',
                    $s3Url
                );
            }

            if (!empty($uploadedDriverFiles)) {
                $driver->update($uploadedDriverFiles);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data driver baru berhasil didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mendaftarkan driver: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|max:15',
            'address'            => 'required|string',
            'status'             => 'required|in:available,assigned,off,suspended',
            'license_number'     => 'required|string|max:50',
            'license_type'       => 'required|in:A,B1,B2,C,Internasional',
            'license_expired'    => 'required|date',
            'avatar_path'        => 'nullable|image|mimes:jpeg,png,jpg',
            'license_image_path' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        $phoneExists = Driver::where('phone', $request->phone)
            ->where('id', '!=', $id)
            ->exists();

        if ($phoneExists) {
            return redirect()->back()->with('error', 'Gagal update: Nomor WhatsApp sudah digunakan oleh driver lain.');
        }

        $licenseExists = Driver::where('license_number', $request->license_number)
            ->where('id', '!=', $id)
            ->exists();

        if ($licenseExists) {
            return redirect()->back()->with('error', 'Gagal update: Nomor SIM sudah digunakan oleh driver lain.');
        }

        DB::beginTransaction();

        try {
            $folderPath = 'drivers/' . $driver->id;

            if ($request->hasFile('avatar_path')) {
                if ($driver->avatar_path) {
                    $oldAvatarPath = Str::after($driver->avatar_path, '/public/');
                    Storage::disk('supabase')->delete($oldAvatarPath);
                }

                $file = $request->file('avatar_path');
                $extension = $file->getClientOriginalExtension();
                $fileName = 'foto_profil.' . $extension;

                $path = Storage::disk('supabase')->putFileAs($folderPath, $file, $fileName);

                $s3Url = Storage::disk('supabase')->url($path);
                $validated['avatar_path'] = str_replace(
                    '.storage.supabase.co/storage/v1/s3/',
                    '.supabase.co/storage/v1/object/public/',
                    $s3Url
                );
            } else {
                unset($validated['avatar_path']);
            }

            if ($request->hasFile('license_image_path')) {
                if ($driver->license_image_path) {
                    $oldLicensePath = Str::after($driver->license_image_path, '/public/');
                    Storage::disk('supabase')->delete($oldLicensePath);
                }

                $file = $request->file('license_image_path');
                $extension = $file->getClientOriginalExtension();
                $fileName = 'foto_sim.' . $extension;

                $path = Storage::disk('supabase')->putFileAs($folderPath, $file, $fileName);

                $s3Url = Storage::disk('supabase')->url($path);
                $validated['license_image_path'] = str_replace(
                    '.storage.supabase.co/storage/v1/s3/',
                    '.supabase.co/storage/v1/object/public/',
                    $s3Url
                );
            } else {
                unset($validated['license_image_path']);
            }

            $driver->update($validated);

            DB::commit();
            return redirect()->back()->with('success', 'Informasi driver berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data driver: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($driver->avatar_path) {
                $oldAvatarPath = Str::after($driver->avatar_path, '/public/');
                Storage::disk('supabase')->delete($oldAvatarPath);
            }

            if ($driver->license_image_path) {
                $oldLicensePath = Str::after($driver->license_image_path, '/public/');
                Storage::disk('supabase')->delete($oldLicensePath);
            }

            $driver->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Data driver berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal Menghapus data driver: ' . $e->getMessage());
        }
    }
}
