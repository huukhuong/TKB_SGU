<div class="col-12">
    <div class="card card-primary">
        <div class="p-2">
            <div class="pl-4 pt-2">
                Đang hiển thị {{ $paginator->currentPage() }}
                trên {{ $paginator->lastPage() }} trang
                của {{ number_format($paginator->total()) }} records
            </div>
        </div>

        @if ($paginator->lastPage() > 1)
            <ul class="pagination px-4" style="flex-wrap: wrap">
                <li class="paginate_button page-item previous {{ $paginator->currentPage() == 1 ? ' disabled' : '' }}">
                    <a href="{{ $paginator->url(1) }}" class="page-link">Previous</a>
                </li>
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <li class="paginate_button page-item {{ $paginator->currentPage() == $i ? ' active' : '' }}">
                        <a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endfor
                <li
                    class="paginate_button page-item next {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
                    <a href="{{ $paginator->url($paginator->currentPage() + 1) }}" class="page-link">Next</a>
                </li>
            </ul>
        @endif
    </div>
</div>
