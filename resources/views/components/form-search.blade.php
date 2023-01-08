<form action="{{ route('sach.search') }}" class="d-flex align-items-center w-100 bg-form  px-3  form-search" method="GET"
    autocomplete="off">
    <div class="py-2 w-50  border-select">
        <select class="form-select border-0  w-100 " aria-label="Default select example" name="select_search">
            <option value="nhande"
                {{ isset($_GET['select_search']) ? ($_GET['select_search'] == 'nhanhde' ? 'selected' : '') : '' }}>Nhan
                đề sách</option>
            <option value="tacgia"
                {{ isset($_GET['select_search']) ? ($_GET['select_search'] == 'tacgia' ? 'selected' : '') : '' }}>Tác
                giả</option>
            <option value="danhmuc"
                {{ isset($_GET['select_search']) ? ($_GET['select_search'] == 'danhmuc' ? 'selected' : '') : '' }}>Danh
                mục</option>
        </select>
    </div>
    <input type="text" name="key" id="key" class="form-control border-0 " placeholder="Bạn cần tìm..."
        required value="{{ isset($_GET['key']) ? $_GET['key'] : '' }}">
    <button type="submit" class="btn btn-primary "><i class="bi bi-search"></i></button>
</form>
