<div class="card card-widget-box" style="width: {{ $width }}">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <div class="card-title">
                    <span>{{ $label }}</span>
                </div>
                <div class="card-data">
                    <span>{{ $data }}</span>
                </div>
            </div>
            <div>
                <div class="rounded-circle p-2" style="background-color: {{ $color }}">
                    <center><i class="{{ $icon }}"></i></center>
                </div>
            </div>
        </div>
    </div>
</div>
