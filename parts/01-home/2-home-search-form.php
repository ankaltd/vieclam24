<div class="search-box-version2" style="z-index:1">
    <form class="" autocomplete="off">
        <div class="w-full flex text-sm relative bg-white p-2 rounded-md shadow-md">
            <div class="w-[37%] bg-white h-10 text-grey-50 relative">
                <div class="w-full h-full flex items-center justify-center relative"><i class="svicon-search text-se-neutral-100 text-lg px-2"></i><input type="text" name="q" class="w-full tracking-tight focus:outline-none focus:text-black pr-4" placeholder="Nhập vị trí muốn ứng tuyển"></div>
                <div class="hidden w-full mt-0 bg-white absolute search-suggest top-[45px] lg:top-14 left-0 rounded-[8px] border-se-accent-20 px-4 py-2" style="z-index:3">
                    <div class="grid grid-cols-2">
                        <div class="col-span-2">
                            <h5 class="text-se-accent-100 text-16 font-bold mb-2">Từ khóa phổ biến</h5>
                            <ul>
                                <li class="px-1 py-2 rounded-[4px] hover:bg-se-highlight cursor-pointer">
                                    <div class="text-se-neutral-80 font-bold"><i class="svicon-star mr-[6px] text-se-alert-yellow"></i>Kế toán</div>
                                </li>
                                <li class="px-1 py-2 rounded-[4px] hover:bg-se-highlight cursor-pointer">
                                    <div class="text-se-neutral-80 font-bold"><i class="svicon-star mr-[6px] text-se-alert-yellow"></i>marketing</div>
                                </li>
                                <li class="px-1 py-2 rounded-[4px] hover:bg-se-highlight cursor-pointer">
                                    <div class="text-se-neutral-80 font-bold"><i class="svicon-star mr-[6px] text-se-alert-yellow"></i>Lái xe</div>
                                </li>
                                <li class="px-1 py-2 rounded-[4px] hover:bg-se-highlight cursor-pointer">
                                    <div class="text-se-neutral-80 font-bold"><i class="svicon-star mr-[6px] text-se-alert-yellow"></i>Chăm sóc khách hàng</div>
                                </li>
                                <li class="px-1 py-2 rounded-[4px] hover:bg-se-highlight cursor-pointer">
                                    <div class="text-se-neutral-80 font-bold"><i class="svicon-star mr-[6px] text-se-alert-yellow"></i>thực tập sinh</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-[30%] bg-white text-black border-r border-l">
                <div class="w-full h-full flex items-center justify-center relative"><i class="svicon-suitcase svicon-select text-se-neutral-100-n absolute left-2 pt-[2px]"></i>
                    <div class="flex-1">
                        <div class="border-none select-search-custom css-b62m3t-container"><span id="react-select-2-live-region" class="css-7pg0cj-a11yText"></span><span aria-live="polite" aria-atomic="false" aria-relevant="additions text" class="css-7pg0cj-a11yText"></span>
                            <div class=" css-vqi1sg-control">
                                <div class=" css-1gcs5og">
                                    <div class=" css-16oca85-placeholder" id="react-select-2-placeholder">Tất cả nghề nghiệp</div>
                                    <div class=" css-ackcql" data-value=""><input class="" autocapitalize="none" autocomplete="off" autocorrect="off" id="react-select-2-input" spellcheck="false" tabindex="0" type="text" aria-autocomplete="list" aria-expanded="false" aria-haspopup="true" role="combobox" aria-describedby="react-select-2-placeholder" value="" style="color: inherit; background: 0px center; opacity: 1; width: 100%; grid-area: 1 / 2; font: inherit; min-width: 2px; border: 0px; margin: 0px; outline: 0px; padding: 0px;"></div>
                                </div>
                                <div class=" css-1wy0on6">
                                    <div class=" css-tlfecz-indicatorContainer" aria-hidden="true"><i class="icon-dropdown"></i></div>
                                </div>
                            </div>
                            <div><input name="occupation_ids" type="hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-[30%] bg-white text-black">
                <div class="w-full h-full flex items-center justify-center relative"><i class="svicon-location svicon-select text-se-neutral-100-n absolute left-2 pt-[2px]"></i>
                    <div class="select-search-custom">
                        <div class="select-search-custom__value"><input tabindex="0" autocomplete="on" value="Tất cả tỉnh thành" class="select-search-custom__input select-icon-padding !rounded-[4px] !text-grey-50"></div>
                    </div>
                </div>
            </div>
            <div class="w-[180px] min-w-[180px] bg-pri-100 !h-10 cursor-pointer top-0 flex rounded-[6px] btn-box"><button type="submit" class="text-white font-medium flex items-center justify-center w-full" id="search-job"><i class="svicon-search text-[18px] mr-1"></i>Tìm việc</button></div>
        </div>
    </form>
    <style>
        .search-box-version2 {
            @media screen and (max-width: 1169px) {
                width: 479px;
                top: calc(50% - 100px);
            }

            @media screen and (max-width: 576px) {
                width: 100%;
                top: 0;
                border-radius: 0;

                .search-suggest {
                    top: 54px;
                }
            }

            .keyword-list {
                span {
                    padding: 6px;
                    font-size: 12px;

                    @media screen and (max-width: 768px) {
                        padding: 2px;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }

                    &:hover {
                        background: rgba(29, 27, 33, 0.25);
                        border-radius: 4px;
                        cursor: pointer;
                    }
                }
            }

            .btn-box {
                height: calc(100% - 4px);
                border-radius: 6px;
            }

            .select-icon-padding {
                padding-left: 30px !important;
            }

            .svicon-select {
                top: calc(50% - 10px);
                z-index: 2;
            }
        }
    </style>
</div>