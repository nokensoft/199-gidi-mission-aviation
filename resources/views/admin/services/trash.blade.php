@include('admin.partials.trash', [
    'title' => 'Layanan',
    'items' => $services,
    'columns' => [
        ['label' => 'Judul', 'html' => fn($item) => '<span class="font-medium text-slate-900">' . e($item->title) . '</span>'],
        ['label' => 'Deskripsi', 'html' => fn($item) => '<span class="text-slate-500">' . Str::limit($item->description, 60) . '</span>'],
    ],
    'backRoute' => 'admin.services.index',
    'restoreRoute' => 'admin.services.restore',
    'forceDeleteRoute' => 'admin.services.force-delete',
])
