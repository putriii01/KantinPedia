<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Menampilkan katalog kantin untuk siswa dan guru
     */
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->get();

        $announcement = null;
        $contact = null;

        if (Schema::hasTable('infos')) {
            $announcement = DB::table('infos')->where('key', 'announcement')->first();
            $contact = DB::table('infos')->where('key', 'contact')->first();
        } elseif (Schema::hasTable('settings')) {
            $announcement = DB::table('settings')->where('key', 'announcement')->first();
            $contact = DB::table('settings')->where('key', 'contact')->first();
        }

        // Nilai fallback jika database belum terisi
        $announcement = $announcement ?? (object)['value' => ''];
        $contact = $contact ?? (object)['value' => '081234567890'];

        return view('home', compact('menus', 'announcement', 'contact'));
    }
}