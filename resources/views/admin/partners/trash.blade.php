@include('admin.partials.trash', [
    'title' => 'Mitra Kerja',
    'items' => $partners,
    'columns' => [
        ['label' => 'Nama', 'html' => fn($item) => '<span class="font-medium text-blue-600">' . e($item->name) . '</span>'],
        ['label' => 'Nama Lengkap', 'field' => 'full_name'],
    ],
    'backRoute' => 'admin.partners.index',
    'restoreRoute' => 'admin.partners.restore',
    'forceDeleteRoute' => 'admin.partners.force-delete',
])
