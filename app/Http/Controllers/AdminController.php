<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class pembantu agar data teks aman dibaca baik sebagai String maupun Object di Blade
 */
class SafeInfo implements \Stringable
{
    public string $value;
    public string $announcement;
    public string $contact;
    public string $operationalHours;
    public string $operational_hours;

    public function __construct($value = '')
    {
        $str = is_object($value) ? (string)($value->value ?? '') : (string)($value ?? '');
        $this->value = $str;
        $this->announcement = $str;
        $this->contact = $str;
        $this->operationalHours = $str;
        $this->operational_hours = $str;
    }

    public function __get($name)
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

class AdminController extends Controller
{
    /**
     * 1. Menampilkan Halaman Dashboard Admin
     */
    public function dashboard()
    {
        $menus = Menu::orderBy('id', 'desc')->get();

        $announcementText = '';
        $contactText = '';
        $operationalHoursText = '07:00 - 14:30';

        if (Schema::hasTable('infos')) {
            $announcementText = DB::table('infos')->where('key', 'announcement')->value('value') ?? '';
            $contactText = DB::table('infos')->where('key', 'contact')->value('value') ?? '';
            $operationalHoursText = DB::table('infos')->whereIn('key', ['operational_hours', 'operationalHours', 'hours'])->value('value') ?? '07:00 - 14:30';
        } elseif (Schema::hasTable('settings')) {
            $announcementText = DB::table('settings')->where('key', 'announcement')->value('value') ?? '';
            $contactText = DB::table('settings')->where('key', 'contact')->value('value') ?? '';
            $operationalHoursText = DB::table('settings')->whereIn('key', ['operational_hours', 'operationalHours', 'hours'])->value('value') ?? '07:00 - 14:30';
        }

        $announcement     = new SafeInfo($announcementText);
        $contact          = new SafeInfo($contactText);
        $operationalHours = new SafeInfo($operationalHoursText);
        $operational_hours = $operationalHours;
        $information      = new SafeInfo($announcementText);
        $info             = $information;

        return view('admin.dashboard', compact(
            'menus', 
            'announcement', 
            'contact', 
            'operationalHours', 
            'operational_hours', 
            'information', 
            'info'
        ));
    }

    /**
     * Alias method index
     */
    public function index()
    {
        return $this->dashboard();
    }

    /**
     * 2. Tambah Menu Baru
     */
    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'stan_name'   => 'required|string|max:255',
            'stan_phone'  => 'nullable|string|max:30',
            'price'       => 'required|numeric|min:0',
            'badge'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menus', 'public');
        }

        $validated['is_available'] = true;

        Menu::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * 3. Update Menu
     */
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'stan_name'   => 'required|string|max:255',
            'stan_phone'  => 'nullable|string|max:30',
            'price'       => 'required|numeric|min:0',
            'badge'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $validated['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * 4. Toggle Status Ketersediaan (Tersedia / Habis)
     */
    public function toggleAvailability($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_available = !$menu->is_available;
        $menu->save();

        return redirect()->route('admin.dashboard')->with('success', 'Status menu berhasil diubah!');
    }

    /**
     * 5. Hapus Menu
     */
    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * 6. Update Informasi Kantin
     */
    public function updateInfo(Request $request)
    {
        $announcementText = $request->input('announcement', '');
        $contactText = $request->input('contact', '');
        $hoursText = $request->input('operational_hours', $request->input('operationalHours', '07:00 - 14:30'));

        if (Schema::hasTable('infos')) {
            DB::table('infos')->updateOrInsert(['key' => 'announcement'], ['value' => $announcementText]);
            DB::table('infos')->updateOrInsert(['key' => 'contact'], ['value' => $contactText]);
            DB::table('infos')->updateOrInsert(['key' => 'operational_hours'], ['value' => $hoursText]);
        } elseif (Schema::hasTable('settings')) {
            DB::table('settings')->updateOrInsert(['key' => 'announcement'], ['value' => $announcementText]);
            DB::table('settings')->updateOrInsert(['key' => 'contact'], ['value' => $contactText]);
            DB::table('settings')->updateOrInsert(['key' => 'operational_hours'], ['value' => $hoursText]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Informasi kantin berhasil diperbarui!');
    }

    /**
     * 7. Cetak Katalog Fisik A4
     */
    public function printCatalog()
    {
        $menus = Menu::orderBy('category')->orderBy('name')->get();

        if (view()->exists('admin.print')) {
            return view('admin.print', compact('menus'));
        }

        return view('admin.dashboard', compact('menus'));
    }
}