@include('admin.partials.trash', [
    'title' => 'Slider',
    'items' => $sliders,
    'columns' => [
        ['label' => 'Judul', 'html' => fn($item) => '<span class="font-medium text-slate-900">' . e($item->title) . '</span>'],
        ['label' => 'Subtitle', 'field' => 'subtitle'],
    ],
    'backRoute' => 'admin.sliders.index',
    'restoreRoute' => 'admin.sliders.restore',
    'forceDeleteRoute' => 'admin.sliders.force-delete',
])
