@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Transaksi perawatan barang dan mesin</span>
                    <span class="badge badge-light">{{ $baris }} barang</span>
                </div>
                <div class="card-body">
                    @if($baris > 0)
                    <div class="maintenance-list">
                        @foreach($barangGroups as $group)
                        <details class="maintenance-group" {{ $loop->first ? 'open' : '' }}>
                            <summary class="maintenance-trigger">
                                <span class="maintenance-summary-icon">
                                    <i class="fa fa-chevron-right maintenance-chevron"></i>
                                </span>
                                <span class="maintenance-summary-body">
                                    <span class="maintenance-main">
                                        <span class="maintenance-code">{{ $group->kode }}</span>
                                        <span class="maintenance-name">{{ $group->nama }}</span>
                                    </span>
                                    <span class="maintenance-meta">
                                        <span class="maintenance-count">{{ $group->detail_count }} sub barang</span>
                                        <span class="maintenance-total">Rp {{ number_format($group->grand_total, 2, ',', '.') }}</span>
                                    </span>
                                </span>
                            </summary>

                            <div class="maintenance-panel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 24%">NUP / Kode sub barang</th>
                                                <th>Nama sub barang</th>
                                                <th style="width: 20%" class="text-right">Subtotal perawatan</th>
                                                <th style="width: 12%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($group->details as $item)
                                            <tr class="{{ $item->is_orphan ? 'table-warning' : '' }}">
                                                <td>{{ $item->kode_detail_barang }}</td>
                                                <td>
                                                    {{ $item->nama_detail_barang }}
                                                    @if($item->is_orphan)
                                                    <div class="maintenance-note">
                                                        Transaksi ini masih ada, tetapi data sub barangnya tidak ditemukan di master detail.
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="text-right">Rp {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                                <td class="text-center">
                                                    @if($item->is_orphan)
                                                    <span class="btn btn-secondary btn-sm disabled">Tidak tersedia</span>
                                                    @else
                                                    <a href="{{ route('transaksi_perawatan.detail', ['id_detail_barang' => $item->id_detail_barang]) }}" class="btn btn-primary btn-sm">
                                                        Detail
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </details>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        Belum ada data sub barang untuk transaksi perawatan.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .maintenance-list {
        display: grid;
        gap: 16px;
    }

    .maintenance-group {
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: 0 12px 22px rgba(31, 55, 96, 0.08);
        overflow: hidden;
        background: #fff;
    }

    .maintenance-group[open] {
        border-color: #b9cee9;
        box-shadow: 0 16px 28px rgba(31, 55, 96, 0.12);
    }

    .maintenance-trigger {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px 20px;
        color: var(--text);
        background: linear-gradient(135deg, #ffffff 0%, #f6f9ff 100%);
        cursor: pointer;
        list-style: none;
    }

    .maintenance-trigger::-webkit-details-marker {
        display: none;
    }

    .maintenance-trigger:hover,
    .maintenance-trigger:focus {
        color: var(--text);
        background: linear-gradient(135deg, #fefefe 0%, #edf4ff 100%);
    }

    .maintenance-summary-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--surface-muted);
        color: var(--brand-soft);
        flex-shrink: 0;
    }

    .maintenance-summary-body {
        width: 100%;
        min-width: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .maintenance-main {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .maintenance-code {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        color: var(--brand-soft);
        text-transform: uppercase;
    }

    .maintenance-name {
        font-size: 18px;
        font-weight: 800;
        color: var(--brand-dark);
    }

    .maintenance-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .maintenance-count {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-soft);
        background: var(--surface-muted);
        border-radius: 999px;
        padding: 7px 10px;
    }

    .maintenance-total {
        font-size: 15px;
        font-weight: 800;
        color: var(--ok);
    }

    .maintenance-chevron {
        transition: transform .2s ease;
    }

    .maintenance-group[open] .maintenance-chevron {
        transform: rotate(90deg);
    }

    .maintenance-panel {
        padding: 0 20px 20px;
        background: #fff;
    }

    .maintenance-note {
        margin-top: 6px;
        font-size: 12px;
        color: #8a5a11;
        font-weight: 600;
    }

    .maintenance-list .table thead th {
        background: #edf4ff;
    }

    @media (max-width: 768px) {
        .maintenance-trigger {
            padding: 16px;
        }

        .maintenance-summary-body {
            flex-direction: column;
            align-items: flex-start;
        }

        .maintenance-meta {
            width: 100%;
            justify-content: flex-start;
        }

        .maintenance-panel {
            padding: 0 14px 16px;
        }
    }
</style>
@endpush
