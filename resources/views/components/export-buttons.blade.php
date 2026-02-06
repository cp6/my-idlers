@props(['route'])

<div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Export">
        <i class="fas fa-download"></i><span class="d-none d-md-inline ms-1">Export</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route($route, ['format' => 'json']) }}"><i class="fas fa-file-code me-2 text-primary"></i>Export as JSON</a></li>
        <li><a class="dropdown-item" href="{{ route($route, ['format' => 'csv']) }}"><i class="fas fa-file-csv me-2 text-success"></i>Export as CSV</a></li>
    </ul>
</div>
