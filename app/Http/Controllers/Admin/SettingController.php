<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'site_name', 'site_tagline', 'site_description',
            'contact_phone_1', 'contact_name_1', 'contact_title_1',
            'contact_phone_2', 'contact_name_2', 'contact_title_2',
            'office_address', 'office_email',
            'bank_name', 'bank_branch', 'bank_account', 'bank_holder',
            'facebook_url', 'instagram_url', 'youtube_url',
            'president_name', 'president_title', 'president_quote',
            'about_title', 'about_verse', 'about_verse_ref',
            'fundraising_title', 'fundraising_description',
            'aircraft_title', 'aircraft_description',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->input($field));
            }
        }

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $request->validate(['site_logo' => 'image|max:10240']);
            $path = ImageHelper::convertToWebp($request->file('site_logo'), 'branding', 90, 512);
            SiteSetting::set('site_logo', $path, 'image');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $request->validate(['site_favicon' => 'image|max:5120']);
            $path = ImageHelper::convertToWebp($request->file('site_favicon'), 'branding', 90, 180);
            SiteSetting::set('site_favicon', $path, 'image');
        }

        // Handle contact photo uploads & deletion
        foreach ([1, 2] as $i) {
            if ($request->input("delete_contact_photo_{$i}") === '1' && !$request->hasFile("contact_photo_{$i}")) {
                $oldPath = SiteSetting::get("contact_photo_{$i}");
                if ($oldPath && file_exists(public_path('uploads/' . $oldPath))) {
                    unlink(public_path('uploads/' . $oldPath));
                }
                SiteSetting::set("contact_photo_{$i}", '', 'image');
            } elseif ($request->hasFile("contact_photo_{$i}")) {
                $request->validate(["contact_photo_{$i}" => 'image|max:5120']);
                $oldPath = SiteSetting::get("contact_photo_{$i}");
                if ($oldPath && file_exists(public_path('uploads/' . $oldPath))) {
                    unlink(public_path('uploads/' . $oldPath));
                }
                $path = ImageHelper::convertToWebp($request->file("contact_photo_{$i}"), 'contacts', 90, 300);
                SiteSetting::set("contact_photo_{$i}", $path, 'image');
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function pages()
    {
        $pages = Page::all();
        return view('admin.settings.pages', compact('pages'));
    }

    public function editPage(Page $page)
    {
        return view('admin.settings.edit-page', compact('page'));
    }

    public function updatePage(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page->update($validated);

        return redirect()->route('admin.settings.pages')->with('success', 'Halaman berhasil diperbarui.');
    }
}
