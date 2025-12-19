<div class="rectangle">
    <div class="group-ngoai-khoi-sach">
        <div class="group-tach-khoi-sach">

            {{-- === KHỐI 1: CHI TIẾT TIỀN PHẠT === --}}
            <div class="group-khoi-sach">
                <div class="title-khoi-sach">Chi tiết tiền phạt</div>

                @if($phats->isEmpty())
                <div class="no-phat">
                    <p>Bạn không có phiếu phạt nào.</p>
                </div>
                @else
                @php
                $tongTienPhat = $phats->sum('soTienPhat');
                @endphp

                @foreach($phats as $phat)
                <div class="khung-chung-sach-lch">
                    <div class="khung-chu-sach-lch">
                        <div class="text-wrapper-8">{{ $phat->phieuMuonChiTiet->sach->tenSach ?? 'Sách' }}</div>
                        <div class="text-wrapper-9">Tác giả: {{ $phat->phieuMuonChiTiet->sach->tacGia ?? '...' }}</div>
                        <div class="muc-date-phat">
                            <div class="text-wrapper-7">
                                Hạn trả: {{ \Carbon\Carbon::parse($phat->phieuMuonChiTiet->due_date ?? now())->format('d/m/Y') }}
                            </div>
                            <div class="text-wrapper-7">
                                Ngày trả: {{ \Carbon\Carbon::parse($phat->phieuMuonChiTiet->return_date ?? now())->format('d/m/Y') }}
                            </div>
                            <div class="text-wrapper-7">Số ngày trễ: {{ $phat->soNgayTre }} ngày</div>
                            <div class="text-wrapper-7">Phạt/ngày: 5.000đ</div>
                        </div>
                    </div>
                </div>
                @endforeach


                {{-- Tổng tiền phạt --}}
                <div class="rectangle-tong-tien-phat">
                    <div class="text-tong-phat">Tổng tiền phạt:</div>
                    <div class="so-tien-phat">{{ number_format($tongTienPhat,0,',','.') }}đ</div>
                </div>
                @endif
            </div>

            {{-- === KHỐI 2: PHƯƠNG THỨC THANH TOÁN === --}}
            @if($phats->isNotEmpty())
            <div class="group-khoi-sach">
                <div class="title-khoi-sach">Phương thức thanh toán</div>

                {{-- Chuyển khoản --}}
                <div class="khung-chung-sach-lch thanh-toan active">
                    <div class="khung-anh-sach-lch">
                        <img class="image circle-pick" src="{{ asset('images/circle-active.png') }}" alt="Chọn" />
                        <img class="image" src="{{ asset('images/iconstack.io - (Bank Duotone).png') }}" alt="Ngân hàng" />
                    </div>
                    <div class="khung-chu-sach-lch">
                        <div class="text-wrapper-8">Chuyển khoản ngân hàng</div>
                        <div class="text-wrapper-9">Thanh toán qua mã QR</div>
                    </div>
                </div>

                {{-- Tiền mặt --}}
                <div class="khung-chung-sach-lch thanh-toan">
                    <div class="khung-anh-sach-lch">
                        <img class="image circle-pick" src="{{ asset('images/circle-gray.png') }}" alt="Chưa chọn" />
                        <img class="image" src="{{ asset('images/iconstack.io - (Hand Money).png') }}" alt="Tiền mặt" />
                    </div>
                    <div class="khung-chu-sach-lch">
                        <div class="text-wrapper-8">Thanh toán tiền mặt</div>
                        <div class="text-wrapper-9">Thanh toán trực tiếp tại quầy thư viện</div>
                    </div>
                </div>

                {{-- Thông tin chuyển khoản + QR --}}
                @php $phatFirst = $phats->first(); @endphp
                <div class="rectangle-thong-tin-chuyen-khoan">
                    <div class="title-thong-tin-chuyen-khoan">Thông tin chuyển khoản</div>
                    <div class="body-thong-tin-chuyen-khoan">
                        <div class="body-detail-thong-tin-ck">
                            <div class="text-detail-ck">Ngân hàng:</div>
                            <div class="text-info-ck">NGÂN HÀNG QUÂN ĐỘI MBBANK</div>
                        </div>
                        <div class="body-detail-thong-tin-ck">
                            <div class="text-detail-ck">Số tài khoản:</div>
                            <div class="text-info-ck">0363572964</div>
                        </div>
                        <div class="body-detail-thong-tin-ck">
                            <div class="text-detail-ck">Chủ tài khoản:</div>
                            <div class="text-info-ck">THU VIEN TRUONG DAI HOC</div>
                        </div>
                        <div class="body-detail-thong-tin-ck">
                            <div class="text-detail-ck">Nội dung:</div>
                            <div class="text-info-ck">
                                THANHTOANPHAT_{{ Auth::user()->idNguoiDung }}_{{ $phatFirst->phieuMuonChiTiet->sach->idSach }}
                            </div>
                        </div>

                        {{-- QR code tĩnh --}}
                        <div class="body-detail-thong-tin-ck qr-section">
                            <div class="text-detail-ck">Quét mã để thanh toán nhanh:</div>
                            <img src="{{ asset('images/qr-thanh-toan.png') }}" alt="QR Thanh toán" class="qr-image">
                        </div>
                    </div>

                    <div class="footer-detail-thong-tin-ck">
                        <div class="text-footer-ck">Số tiền:</div>
                        <div class="text-footer-info-ck">{{ number_format($tongTienPhat,0,',','.') }}đ</div>
                    </div>
                </div>

                {{-- Nút thanh toán --}}
                <a class="rectangle-thanh-toan" href="{{ url('user/xac-nhan-thanh-toan') }}">
                    <img class="img-thanh-toan" src="{{ asset('images/iconstack.io - (Credit Card 2 Back Fill).png') }}" alt="Thanh toán" />
                    <div class="text-thanh-toan">Gửi yêu cầu xác nhận thanh toán</div>
                </a>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    .qr-section {
        text-align: center;
        margin-top: 15px;
    }

    .qr-image {
        width: 160px;
        height: 160px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .no-phat {
        text-align: center;
        font-size: 25px;
        color: #666;
        padding: 50% 0;
    }
</style>