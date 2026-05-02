<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Most Expensive Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { padding: 40px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }

        .page-header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h2 { margin: 0; font-weight: 700; color: #2d3748; }
        .page-header h2 i { color: #f59e0b; margin-right: 10px; }

        .stats-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 500;
        }

        .table-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .table thead th {
            border-bottom: 2px solid #e2e8f0;
            color: #4a5568;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 15px;
            background: #f7fafc;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody tr:hover {
            background: #fffbeb;
        }

        .category-name {
            font-weight: 700;
            color: #2d3748;
        }

        .service-name {
            font-weight: 600;
            color: #2d3748;
        }

        .no-service {
            color: #9ca3af;
            font-style: italic;
        }

        .price-tag {
            font-weight: 700;
            color: #f59e0b;
            font-size: 1.1rem;
        }

        .description-preview {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #718096;
            cursor: help;
        }

        .description-preview:hover {
            white-space: normal;
            overflow: visible;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            position: absolute;
            z-index: 1000;
            max-width: 350px;
        }

        .availability-badge {
            background: #d1fae5;
            color: #065f46;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }

        .footer-note {
            margin-top: 30px;
            text-align: center;
            color: #718096;
        }

        .footer-note i {
            color: #ef4444;
            margin: 0 3px;
        }

        .highlight-row {
            background: linear-gradient(90deg, #fef3c7 0%, #fffbeb 100%);
        }

        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="page-header">
        <h2>
            <i class="fas fa-trophy"></i>
            Categories with Most Expensive Service
        </h2>
        <div class="d-flex align-items-center gap-3">
            <span class="stats-badge">
                <i class="fas fa-layer-group me-2"></i>
                {{ count($categories) }} Categories
            </span>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="20%">Category</th>
                        <th width="25%">Most Expensive Service</th>
                        <th width="12%">Price</th>
                        <th width="25%">Description</th>
                        <th width="13%">Availability</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="{{ $category['service_name'] == '-' ? '' : 'highlight-row' }}">
                        <td>
                            <span class="fw-semibold">{{ $category['category_id'] }}</span>
                        </td>
                        <td>
                            <div class="category-name">
                                <i class="fas fa-folder text-warning me-2"></i>
                                {{ $category['category_name'] }}
                            </div>
                        </td>
                        <td>
                            @if($category['service_name'] == '-')
                                <span class="no-service">
                                    <i class="fas fa-minus-circle me-2"></i>
                                    {{ $category['service_name'] }}
                                </span>
                            @else
                                <div class="service-name">
                                    <i class="fas fa-crown text-warning me-2"></i>
                                    {{ $category['service_name'] }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($category['price'])
                                <span class="price-tag">
                                    Rp. {{ number_format($category['price'], 0) }}
                                </span>
                            @else
                                <span class="no-service">-</span>
                            @endif
                        </td>
                        <td>
                            @if($category['description'] != '-')
                                <span class="description-preview" title="{{ $category['description'] }}">
                                    {{ \Illuminate\Support\Str::limit($category['description'], 45, '...') }}
                                </span>
                            @else
                                <span class="no-service">-</span>
                            @endif
                        </td>
                        <td>
                            @if($category['availability'] != '-')
                                <span class="availability-badge">
                                    <i class="far fa-clock me-1"></i>
                                    {{ \Illuminate\Support\Str::limit($category['availability'], 20) }}
                                </span>
                            @else
                                <span class="no-service">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Info -->
        <div class="summary-card">
            <div class="row text-center">
                <div class="col-md-3">
                    <h4 class="fw-bold text-white">{{ count($categories) }}</h4>
                    <small class="text-white-50">Total Categories</small>
                </div>
                <div class="col-md-3">
                    @php
                        $categoriesWithService = count(array_filter($categories, function($cat) {
                            return $cat['service_name'] != '-';
                        }));
                    @endphp
                    <h4 class="fw-bold text-white">{{ $categoriesWithService }}</h4>
                    <small class="text-white-50">Categories with Services</small>
                </div>
                <div class="col-md-3">
                    @php
                        $categoriesWithoutService = count(array_filter($categories, function($cat) {
                            return $cat['service_name'] == '-';
                        }));
                    @endphp
                    <h4 class="fw-bold text-white">{{ $categoriesWithoutService }}</h4>
                    <small class="text-white-50">Categories without Services</small>
                </div>
                <div class="col-md-3">
                    @php
                        $totalValue = array_sum(array_filter(array_column($categories, 'price')));
                    @endphp
                    <h4 class="fw-bold text-white">${{ number_format($totalValue, 0) }}</h4>
                    <small class="text-white-50">Total Most Expensive Value</small>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-note">
        Made with <i class="fas fa-heart"></i> for VitaGuard Health Services
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
