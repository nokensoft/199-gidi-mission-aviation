@include('admin.partials.trash', [
    'title' => 'Artikel',
    'items' => $posts,
    'columns' => [
        ['label' => 'Judul', 'field' => 'title'],
        ['label' => 'Penulis', 'html' => fn($item) => '<span class="text-slate-500">' . ($item->user?->name ?? '-') . '</span>'],
        ['label' => 'Status', 'html' => fn($item) => '<span class="text-xs px-2 py-1 rounded-full font-medium ' . ($item->is_published ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500') . '">' . ($item->is_published ? 'Terbit' : 'Draf') . '</span>'],
    ],
    'backRoute' => 'admin.posts.index',
    'restoreRoute' => 'admin.posts.restore',
    'forceDeleteRoute' => 'admin.posts.force-delete',
])
