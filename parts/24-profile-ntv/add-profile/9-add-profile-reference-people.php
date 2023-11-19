<div>
    <div class="shadow-sd-12 border border-se-bright-gray bg-white rounded-md">
        <div class="flex items-center justify-between p-4 py-2 cursor-pointer border-b border-se-bright-gray px-6">
            <div class="flex items-center text-black font-semibold w-[58%] md:w-[80%]"><span class="text-18 leading-8 font-bold">Thông tin người tham khảo</span></div><span class="flex items-center justify-center h-10 text-primary text-sm font-semibold mr-3 rounded-lg border-none"><i class="svicon-plus-circle text-17 mr-1"></i>Thêm</span>
        </div>
        <div class="pt-4 pb-4 hidden">
            <div class="relative">
                <form class="mx-4 md:mx-10" novalidate="" autocomplete="on">
                    <div class="grid grid-cols-2 gap-6"><input type="hidden" name="idEdit">
                        <div class="flex flex-col">
                            <div class="pb-2 font-semibold text-12 text-[#414045]">Họ và tên </div><input class="w-full rounded-sm text-14 p-3 border-[1.5px] border-se-bright-gray focus:border-primary focus:outline-none h-[40px]" placeholder="Vd: Nguyễn Siêu Việt" name="name">
                        </div>
                        <div class="flex flex-col">
                            <div class="pb-2 font-semibold text-14 text-[#414045]">Số điện thoại </div><input name="phone" autocomplete="off" placeholder="Ví dụ: 0123456789" class="w-full rounded-sm text-14 p-3 border-[1.5px] border-se-bright-gray focus:border-primary focus:outline-none h-[40px] pr-14 h-[44px]" value="">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6 mt-5">
                        <div class="flex flex-col">
                            <div class="pb-2 font-semibold text-12 text-[#414045]">Tên công ty </div><input class="w-full rounded-sm text-14 p-3 border-[1.5px] border-se-bright-gray focus:border-primary focus:outline-none h-[40px]" placeholder="Công ty đã từng làm việc" name="company_name">
                        </div>
                        <div class="flex flex-col">
                            <div class="pb-2 font-semibold text-12 text-[#414045]">Chức vụ </div><input class="w-full rounded-sm text-14 p-3 border-[1.5px] border-se-bright-gray focus:border-primary focus:outline-none h-[40px]" placeholder="" name="position">
                        </div>
                    </div>
                    <div class="w-full pt-6 text-14">
                        <div class="flex justify-end mt-2"><button class="flex items-center justify-center border px-8 py-3 h-11 px-9 bg-primary-4 font-semibold text-primary text-sm h-[40px] rounded-sm border-0 min-w-[160px]" type="button">Hủy</button><button class="flex items-center justify-center border px-8 py-3 h-11 h-10 text-primary text-sm font-semibold rounded border-primary-64 ml-2 min-w-[160px]" type="submit"><i class="svicon-save mr-2"></i>Lưu thông tin</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="flex justify-start mt-3 hidden"></div>
</div>