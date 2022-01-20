<div class="card card-widget-grid" style="width: {{ $width }}">
    <div class="card-body">
        <div class="card-title">
            <span>{{ $label }}</span>
        </div>
        <table class="table table-widget">
            <thead>
                <tr class="font-weight-bold">
                    <td>Link Number</td>
                    <td>Count</td>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <td>{{ $row->getAttribute('link_number') }}</td>
                    <td>{{ $row->getAttribute('count') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
