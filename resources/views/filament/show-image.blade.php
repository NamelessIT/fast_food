<div>
    @if (!empty($imageBase64))
        <!-- Hiển thị ảnh nếu có -->
        <div>Current image:</div>
        <img src="data:image/jpeg;base64,{{ $imageBase64 }}" width="150" height="150" />
    @else
        <p>No image available</p>
    @endif
</div>
