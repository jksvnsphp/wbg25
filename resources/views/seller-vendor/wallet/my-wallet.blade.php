@extends('seller-vendor.seller-frame')

@section('seller-main-content')
<style>
    .table-img {
        height: 6rem !important;
        width: 5rem !important;
        display: flex;
        justify-content: center;
    }

    .table-img img {
        object-fit: fill !important;
        object-position: center center;
    }

    .add_sc {
        font-size: 13px !important;
        font-weight: 600 !important;
    }

    .form-input:focus {
        outline: none !important;
    }
</style>
<section class="container-fluid">
    @php
    $credit = 0;
    $debit = 0;
    @endphp
    @foreach ($wallets as $wallet)
    @php
    $credit += $wallet->credit;
    $debit += $wallet->debit;
    @endphp
    @endforeach
    @php
    $total = $credit - $debit;
    @endphp
    <div class="row">
        <div class="col-md-12 mt-2 bg-primary py-2">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fs-5 text-light mt-2 px-3">
                    My Sale Provision Wallet
                    <a href="{{ route('saleCommissionHelpArticles') }}" class="text-secondary" target="_black">
                        <i class="fa fa-question-circle"></i>
                    </a>
                </h6>
                <h6 class="fs-5 text-light  mt-2 px-3">
                    Wallet Balance: USD
                    @if ($total >= 0)
                    +{{ number_format($total, 2, ',', '.') }}
                    @else
                    -{{ number_format($total, 2, ',', '.') }}
                    @endif
                </h6>
            </div>
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <h6 class="fw-bold py-2">Your Wallet Transactions:</h6>
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="2">Type</th>
                                    <th class="text-center">WBG24 Number</th>
                                    <th class="text-center">Sold</th>
                                    <th class="text-center">Selling Price</th>
                                    <th class="text-center">Your Sell Provision</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wallets as $wallet)
                                @if ($wallet->type == 'member_package' || $wallet->type == 'sale_provision' || $wallet->type == 'sale_provision_deduction')
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <p style="width: 12rem" class="text-capitalize ">
                                            <?php if (!empty($wallet->order_item_id)) {
                                                echo "Product Sale Provision";
                                            } elseif (!empty($wallet->offer_tender_id)) {
                                                echo "Tender Sale Provision";
                                            } else {
                                                echo str_replace('_', ' ', $wallet->type);
                                            }
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <?php if (!empty($wallet->order_item_id)) {
                                            $product_id = $wallet->orderItem->product_id ?? 0;
                                            echo str_pad($product_id, 9, '0', STR_PAD_LEFT);
                                        } elseif (!empty($wallet->offer_tender_id)) {
                                            $tender_id = $wallet->offerTender->tender_id ?? 0;
                                            echo "TN-" . str_pad($tender_id, 6, '0', STR_PAD_LEFT);
                                        } else {
                                            echo "1";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <p class="pb-0 mb-0 text-center fw-bold">
                                            Posted {{ date('d-M-Y', strtotime($wallet->created_at)) }}
                                        </p>
                                        <p class="pb-0 mb-0 text-center fw-bold">
                                            CET {{ date('h:i A', strtotime($wallet->created_at)) }}
                                        </p>
                                    </td>
                                    <td>

                                        <p class="fw-bold mb-0 pb-0 text-center">
                                            <span class="text-success">USD
                                                @if($wallet->type == 'sale_provision' && ($wallet->order_item_id != null))
                                                {{ number_format(getOrderPriceWithoutTax($wallet->order_item_id), 2, '.', ',') }}
                                                @elseif($wallet->type == 'sale_provision_deduction' && ($wallet->order_item_id != null))
                                                {{ number_format(getOrderPriceWithoutTax($wallet->order_item_id), 2, '.', ',') }}
                                                @else
                                                {{ number_format($wallet->credit, 2, '.', ',') }}
                                                @endif

                                            </span>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-0 pb-0 text-center">
                                            <span class="text-danger">USD {{ number_format($wallet->debit, 2, '.', ',') }}</span>
                                        </p>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" onclick="window.history.back()" class="btn text-light"><i
                        class="fas fa-arrow-left "></i> Back</button>
            </div>
        </div>
    </div>
</section>
@endsection