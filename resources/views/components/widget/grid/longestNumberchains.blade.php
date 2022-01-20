<div class="card card-widget-grid" style="width: {{ $width }}">
    <div class="card-body">
        <div class="card-title">
            <span>{{ $label }}</span>
        </div>
        <table class="table table-widget">
            <thead>
                <tr class="font-weight-bold">
                    <td>Starting Number</td>
                    <td>Link Count</td>
                    <td>Number Chain</td>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                <tr>
                    <td>{{ $row->startingNumber() }}</td>
                    <td>{{ $row->numberchainCount() }}</td>
                    <td>{{ $row->numberchain()->pluck('link_number')->join(', ') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
