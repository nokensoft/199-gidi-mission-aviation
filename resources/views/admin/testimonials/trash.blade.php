@include('admin.partials.trash', [
    'title' => 'Testimoni',
    'items' => $testimonials,
    'columns' => [
        ['label' => 'Nama', 'html' => fn($item) => '<span class="font-medium text-slate-900">' . e($item->display_name) . '</span><br><span class="text-xs text-slate-400">' . e($item->role_title) . '</span>'],
        ['label' => 'Testimoni', 'html' => fn($item) => '<span class="text-slate-600">' . Str::limit($item->content, 60) . '</span>'],
    ],
    'backRoute' => 'admin.testimonials.index',
    'restoreRoute' => 'admin.testimonials.restore',
    'forceDeleteRoute' => 'admin.testimonials.force-delete',
])
