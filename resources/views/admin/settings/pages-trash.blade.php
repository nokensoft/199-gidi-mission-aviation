@include('admin.partials.trash', [
    'title' => 'Halaman Statis',
    'items' => $pages,
    'columns' => [
        ['label' => 'Judul', 'html' => fn($item) => '<span class="font-medium text-slate-900">' . e($item->title) . '</span>'],
        ['label' => 'Slug', 'html' => fn($item) => '<span class="text-slate-500">/halaman/' . e($item->slug) . '</span>'],
    ],
    'backRoute' => 'admin.settings.pages',
    'restoreRoute' => 'admin.settings.pages.restore',
    'forceDeleteRoute' => 'admin.settings.pages.force-delete',
])
