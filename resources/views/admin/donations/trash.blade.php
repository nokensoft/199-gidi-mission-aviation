@include('admin.partials.trash', [
    'title' => 'Donasi',
    'items' => $donations,
    'columns' => [
        ['label' => 'Donatur', 'html' => fn($item) => '<span class="font-medium text-slate-900">' . e($item->donor_name) . '</span><br><span class="text-xs text-slate-400">' . e($item->donor_phone) . '</span>'],
        ['label' => 'Paket', 'html' => fn($item) => '<span class="text-xs">' . $item->package_label . '</span>'],
        ['label' => 'Status', 'html' => fn($item) => '<span class="text-xs px-2 py-1 rounded-full font-medium ' . ($item->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600' : ($item->status === 'rejected' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600')) . '">' . ucfirst($item->status) . '</span>'],
    ],
    'backRoute' => 'admin.donations.index',
    'restoreRoute' => 'admin.donations.restore',
    'forceDeleteRoute' => 'admin.donations.force-delete',
])
