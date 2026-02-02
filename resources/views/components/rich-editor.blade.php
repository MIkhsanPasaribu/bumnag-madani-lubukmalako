{{-- 
    Komponen Rich Text Editor menggunakan Summernote
    Gratis, Open Source, Tidak Perlu API Key
    
    Usage:
    <x-rich-editor 
        name="konten" 
        :value="$berita->konten ?? ''" 
        label="Konten Berita"
        required
    />
--}}

@props([
    'name' => 'content',
    'value' => '',
    'label' => 'Konten',
    'required' => false,
    'height' => 350,
    'placeholder' => 'Tulis konten di sini...'
])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-secondary">*</span>
            @endif
        </label>
    @endif

    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="summernote-editor"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
    >{!! old($name, $value) !!}</textarea>

    @error($name)
        <p class="text-sm text-secondary mt-1">{{ $message }}</p>
    @enderror
</div>

@once
    @push('styles')
    {{-- Summernote CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    
    <style>
        /* Custom Summernote Styling */
        .note-editor.note-frame {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            overflow: hidden;
        }
        
        .note-editor.note-frame:focus-within {
            border-color: #86ae5f !important;
            box-shadow: 0 0 0 3px rgba(134, 174, 95, 0.1) !important;
        }
        
        .note-editor .note-toolbar {
            background-color: #f9fafb !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 8px 10px !important;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        
        .note-editor .note-editing-area {
            background: white !important;
        }
        
        .note-editor .note-editable {
            background: white !important;
            padding: 15px !important;
            font-size: 14px !important;
            line-height: 1.7 !important;
            color: #374151 !important;
        }
        
        .note-editor .note-editable p {
            margin-bottom: 0.75rem;
        }
        
        .note-editor .note-statusbar {
            background-color: #f9fafb !important;
            border-top: 1px solid #e5e7eb !important;
        }
        
        /* Toolbar buttons styling */
        .note-btn {
            background-color: white !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 0.375rem !important;
            color: #374151 !important;
            padding: 5px 10px !important;
        }
        
        .note-btn:hover {
            background-color: #f3f4f6 !important;
            border-color: #d1d5db !important;
        }
        
        .note-btn.active, .note-btn:active {
            background-color: #86ae5f !important;
            border-color: #86ae5f !important;
            color: white !important;
        }
        
        .note-dropdown-menu {
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid #e5e7eb !important;
            z-index: 9999 !important;
            position: absolute !important;
            background: white !important;
        }
        
        /* Color Picker Dropdown Fix */
        .note-color .note-dropdown-menu,
        .note-color .dropdown-menu {
            min-width: 180px !important;
            padding: 10px !important;
            z-index: 9999 !important;
        }
        
        .note-holder {
            position: relative !important;
        }
        
        .note-color-palette {
            line-height: 1 !important;
        }
        
        /* CRITICAL: Force color buttons to show their background colors */
        .note-color-palette .note-color-btn,
        .note-holder .note-color-btn {
            width: 20px !important;
            height: 20px !important;
            border: 1px solid rgba(0,0,0,0.15) !important;
            padding: 0 !important;
            margin: 2px !important;
            display: inline-block !important;
            cursor: pointer !important;
            /* Remove Tailwind's transparent background */
            background-color: var(--note-color-value, currentColor) !important;
        }
        
        /* Individual color definitions to override Tailwind reset */
        .note-color-btn[data-value="#000000"] { background-color: #000000 !important; }
        .note-color-btn[data-value="#424242"] { background-color: #424242 !important; }
        .note-color-btn[data-value="#636363"] { background-color: #636363 !important; }
        .note-color-btn[data-value="#9c9c94"] { background-color: #9c9c94 !important; }
        .note-color-btn[data-value="#cec6ce"] { background-color: #cec6ce !important; }
        .note-color-btn[data-value="#efefef"] { background-color: #efefef !important; }
        .note-color-btn[data-value="#f7f7f7"] { background-color: #f7f7f7 !important; }
        .note-color-btn[data-value="#ffffff"] { background-color: #ffffff !important; }
        .note-color-btn[data-value="#ff0000"] { background-color: #ff0000 !important; }
        .note-color-btn[data-value="#ff9c00"] { background-color: #ff9c00 !important; }
        .note-color-btn[data-value="#ffff00"] { background-color: #ffff00 !important; }
        .note-color-btn[data-value="#00ff00"] { background-color: #00ff00 !important; }
        .note-color-btn[data-value="#00ffff"] { background-color: #00ffff !important; }
        .note-color-btn[data-value="#0000ff"] { background-color: #0000ff !important; }
        .note-color-btn[data-value="#9c00ff"] { background-color: #9c00ff !important; }
        .note-color-btn[data-value="#ff00ff"] { background-color: #ff00ff !important; }
        .note-color-btn[data-value="#f44336"] { background-color: #f44336 !important; }
        .note-color-btn[data-value="#e91e63"] { background-color: #e91e63 !important; }
        .note-color-btn[data-value="#9c27b0"] { background-color: #9c27b0 !important; }
        .note-color-btn[data-value="#673ab7"] { background-color: #673ab7 !important; }
        .note-color-btn[data-value="#3f51b5"] { background-color: #3f51b5 !important; }
        .note-color-btn[data-value="#2196f3"] { background-color: #2196f3 !important; }
        .note-color-btn[data-value="#03a9f4"] { background-color: #03a9f4 !important; }
        .note-color-btn[data-value="#00bcd4"] { background-color: #00bcd4 !important; }
        .note-color-btn[data-value="#009688"] { background-color: #009688 !important; }
        .note-color-btn[data-value="#4caf50"] { background-color: #4caf50 !important; }
        .note-color-btn[data-value="#8bc34a"] { background-color: #8bc34a !important; }
        .note-color-btn[data-value="#cddc39"] { background-color: #cddc39 !important; }
        .note-color-btn[data-value="#ffeb3b"] { background-color: #ffeb3b !important; }
        .note-color-btn[data-value="#ffc107"] { background-color: #ffc107 !important; }
        .note-color-btn[data-value="#ff9800"] { background-color: #ff9800 !important; }
        .note-color-btn[data-value="#ff5722"] { background-color: #ff5722 !important; }
        .note-color-btn[data-value="#795548"] { background-color: #795548 !important; }
        .note-color-btn[data-value="#607d8b"] { background-color: #607d8b !important; }
        .note-color-btn[data-value="#86ae5f"] { background-color: #86ae5f !important; }
        .note-color-btn[data-value="#6b9a45"] { background-color: #6b9a45 !important; }
        .note-color-btn[data-value="#b71e42"] { background-color: #b71e42 !important; }
        .note-color-btn[data-value="#8f1734"] { background-color: #8f1734 !important; }
        .note-color-btn[data-value="#fffaed"] { background-color: #fffaed !important; }
        .note-color-btn[data-value="#f3f4f6"] { background-color: #f3f4f6 !important; }
        
        /* Transparent button special styling */
        .note-color-btn[data-value="transparent"],
        .note-color-btn[data-value="inherit"] {
            background: repeating-conic-gradient(#ccc 0% 25%, #fff 0% 50%) 50% / 10px 10px !important;
        }
        
        .note-color-palette .note-color-btn:hover {
            border-color: #000 !important;
            transform: scale(1.2);
            z-index: 10;
            position: relative;
        }
        
        .note-palette-title {
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin: 8px 0 5px 0 !important;
            border: none !important;
        }
        
        .note-color-reset, .note-color-select-btn {
            font-size: 12px !important;
            padding: 5px 10px !important;
            margin-top: 8px !important;
            width: 100% !important;
            background: #f3f4f6 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 4px !important;
            cursor: pointer !important;
            color: #374151 !important;
        }
        
        .note-color-reset:hover, .note-color-select-btn:hover {
            background: #e5e7eb !important;
        }
        
        .note-btn-group {
            margin-right: 5px !important;
        }
        
        /* Placeholder */
        .note-placeholder {
            color: #9ca3af !important;
            padding: 15px !important;
        }
        
        /* Link modal styling */
        .note-modal-content {
            border-radius: 0.75rem !important;
        }
        
        .note-modal-header {
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }
        
        .note-modal-footer {
            border-radius: 0 0 0.75rem 0.75rem !important;
        }
        
        /* Image styling in editor */
        .note-editable img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 0.5rem 0;
        }
        
        /* Table styling in editor */
        .note-editable table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        
        .note-editable table td,
        .note-editable table th {
            border: 1px solid #e5e7eb;
            padding: 8px 12px;
        }
        
        .note-editable table th {
            background-color: #f9fafb;
            font-weight: 600;
        }
        
        /* Blockquote styling */
        .note-editable blockquote {
            border-left: 4px solid #86ae5f;
            padding-left: 1rem;
            margin: 1rem 0;
            color: #6b7280;
            font-style: italic;
        }
        
        /* Code styling */
        .note-editable code {
            background-color: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: ui-monospace, monospace;
            font-size: 0.875em;
        }
        
        .note-editable pre {
            background-color: #1f2937;
            color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1rem 0;
        }
        
        /* List styling - IMPORTANT: Override Tailwind reset */
        .note-editable ul {
            list-style-type: disc !important;
            padding-left: 1.5rem !important;
            margin: 0.75rem 0 !important;
        }
        
        .note-editable ol {
            list-style-type: decimal !important;
            padding-left: 1.5rem !important;
            margin: 0.75rem 0 !important;
        }
        
        .note-editable ul ul {
            list-style-type: circle !important;
        }
        
        .note-editable ul ul ul {
            list-style-type: square !important;
        }
        
        .note-editable ol ol {
            list-style-type: lower-alpha !important;
        }
        
        .note-editable ol ol ol {
            list-style-type: lower-roman !important;
        }
        
        .note-editable li {
            margin-bottom: 0.25rem !important;
            display: list-item !important;
        }
    </style>
    @endpush

    @push('scripts')
    {{-- Summernote JS --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    
    {{-- Summernote Indonesian Language (Optional) --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-id-ID.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initSummernote();
            fixColorPalette();
        });
        
        // Fix color palette after Summernote is initialized
        function fixColorPalette() {
            // Wait a bit for Summernote to fully render
            setTimeout(function() {
                document.querySelectorAll('.note-color-btn').forEach(function(btn) {
                    var color = btn.getAttribute('data-value');
                    if (color && color !== 'inherit' && color !== 'transparent') {
                        btn.style.setProperty('background-color', color, 'important');
                    }
                });
            }, 100);
            
            // Also fix when dropdown is opened
            $(document).on('shown.bs.dropdown', '.note-color', function() {
                $(this).find('.note-color-btn').each(function() {
                    var color = $(this).attr('data-value');
                    if (color && color !== 'inherit' && color !== 'transparent') {
                        $(this).css('background-color', color + ' !important');
                        this.style.setProperty('background-color', color, 'important');
                    }
                });
            });
        }

        function initSummernote() {
            $('.summernote-editor').summernote({
                height: {{ $height }},
                lang: 'id-ID',
                placeholder: '{{ $placeholder }}',
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'pre'],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                    ]
                },
                callbacks: {
                    onImageUpload: function(files) {
                        // Handle image upload to server
                        uploadImage(files[0], this);
                    },
                    onMediaDelete: function(target) {
                        // Optional: handle media deletion
                        console.log('Media deleted');
                    }
                },
                codeviewFilter: false,
                codeviewIframeFilter: true
            });
        }

        // Function to upload image to server
        function uploadImage(file, editor) {
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran gambar maksimal 2MB');
                return;
            }
            
            // Check file type
            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar');
                return;
            }

            var formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route("admin.upload.image") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $(editor).summernote('insertImage', response.url, function($image) {
                            $image.addClass('img-fluid rounded');
                            $image.attr('alt', response.filename || 'Image');
                        });
                    } else {
                        alert(response.message || 'Gagal mengupload gambar');
                    }
                },
                error: function(xhr) {
                    console.error('Upload error:', xhr);
                    // Fallback: use base64 encoding
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        $(editor).summernote('insertImage', reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
    @endpush
@endonce
