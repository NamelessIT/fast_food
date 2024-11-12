<div>
    @if ($imageBase64)
        <!-- Hiển thị ảnh nếu có -->
        <div>Current image:</div>
        <img src="{{ $imageBase64 }}" width="150" height="150" />
    @else
        <p>No image available</p>
    @endif
</div>
