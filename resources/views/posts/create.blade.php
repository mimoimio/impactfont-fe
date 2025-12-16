<x-app-layout>
    <x-slot name="title">Create new post</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Meme Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form id="memeForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Image Upload with Drag & Drop -->
                    <div class="mb-6">
                        <x-label for="imageInput" value="1. Upload Image" />
                        <div id="drop-zone"
                            class="mt-2 border-4 border-dashed border-blue-300 rounded-lg p-8 text-center cursor-pointer transition-all hover:border-blue-500 hover:bg-blue-50">
                            <p id="drop-text" class="text-gray-600">Drag an image here or click to browse</p>
                            <input type="file" id="imageInput" name="image" accept="image/*" class="hidden"
                                required>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Accepted formats: JPG, PNG</p>
                    </div>

                    <!-- Top Text -->
                    <div class="mb-4">
                        <x-label for="topText" value="2. Top Text" />
                        <x-input id="topText" name="top_text" class="block mt-1 w-full" type="text"
                            placeholder="e.g. TOP TEXT" />
                    </div>

                    <!-- Bottom Text -->
                    <div class="mb-4">
                        <x-label for="bottomText" value="3. Bottom Text" />
                        <x-input id="bottomText" name="bottom_text" class="block mt-1 w-full" type="text"
                            placeholder="e.g. BOTTOM TEXT" />
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <x-label for="title" value="4. Post Title" />
                        <x-input id="title" name="title" class="block mt-1 w-full" type="text"
                            placeholder="title" required />
                    </div>

                    <!-- Description/Body -->
                    <div class="mb-6">
                        <x-label for="body" value="5. Description (Optional)" />
                        <textarea id="body" name="body" rows="3"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            placeholder="Add context or a description"></textarea>
                    </div>

                    <!-- Preview Button -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900">
                            Cancel
                        </a>
                        <button type="button" onclick="previewMeme()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Generate Preview
                        </button>
                    </div>
                </form>

                <!-- Loading State -->
                <div id="loading" class="hidden mt-6 text-center">
                    <p class="text-gray-600">Generating your impact font meme...</p>
                </div>

                <!-- Preview Area -->
                <div id="preview-area" class="hidden mt-6">
                    <h3 class="text-lg font-semibold mb-4">Preview Your Meme</h3>
                    <div class="border-4 border-green-300 rounded-lg p-4 bg-gray-50">
                        <img id="meme-preview" class="max-w-full h-auto mx-auto" alt="Meme Preview">
                    </div>

                    <form id="confirmForm" method="POST" action="{{ route('posts.confirm') }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="title" id="confirm-title">
                        <input type="hidden" name="body" id="confirm-body">
                        <input type="hidden" name="top_text" id="confirm-top">
                        <input type="hidden" name="bottom_text" id="confirm-bottom">
                        <input type="hidden" name="meme_data" id="confirm-meme-data">

                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="resetForm()"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Edit
                            </button>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                                Confirm & Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Drag & Drop functionality
        document.addEventListener('DOMContentLoaded', () => {
            const dropZone = document.getElementById('drop-zone');
            const imageInput = document.getElementById('imageInput');
            const dropText = document.getElementById('drop-text');

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('border-green-500', 'bg-green-50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('border-green-500', 'bg-green-50');
                }, false);
            });

            dropZone.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                handleFiles(files);
            }, false);

            dropZone.addEventListener('click', () => {
                imageInput.click();
            });

            imageInput.addEventListener('change', (e) => {
                handleFiles(e.target.files);
            });

            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];
                    if (!file.type.startsWith('image/')) {
                        alert('Please select an image file.');
                        return;
                    }
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    imageInput.files = dataTransfer.files;
                    dropZone.classList.add('border-blue-500', 'bg-blue-50');
                    dropText.textContent = `Selected: ${file.name}`;
                }
            }
        });

        // Compress image to be under 2MB
        async function compressImage(file, maxSizeMB = 2) {
            const maxSizeBytes = maxSizeMB * 1024 * 1024;

            // If file is already small enough, return it
            if (file.size <= maxSizeBytes) {
                return file;
            }

            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;
                        let quality = 0.9;

                        // Start with original dimensions
                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');

                        // Function to try compression with current settings
                        const tryCompress = () => {
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                            canvas.toBlob((blob) => {
                                if (blob.size <= maxSizeBytes || quality <= 0.1) {
                                    // Success or we've tried our best
                                    const compressedFile = new File([blob], file.name, {
                                        type: 'image/jpeg',
                                        lastModified: Date.now()
                                    });
                                    resolve(compressedFile);
                                } else {
                                    // Try reducing quality or size
                                    if (quality > 0.5) {
                                        quality -= 0.1;
                                    } else {
                                        // Reduce dimensions by 10%
                                        width *= 0.9;
                                        height *= 0.9;
                                        canvas.width = width;
                                        canvas.height = height;
                                        quality = 0.9; // Reset quality
                                    }
                                    tryCompress();
                                }
                            }, 'image/jpeg', quality);
                        };

                        tryCompress();
                    };
                    img.onerror = reject;
                    img.src = e.target.result;
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }
        /**
         * Resizes an image to exactly 512x512 (stretching it) and converts it to a Blob/File.
         * @param {File} file - The original image file.
         * @return {Promise<File>} - The resized 512x512 file.
         */
        function resize(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                const size = 256

                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        // 1. Create a canvas with the target dimensions
                        const canvas = document.createElement('canvas');
                        canvas.width = size;
                        canvas.height = size;

                        const ctx = canvas.getContext('2d');

                        // 2. Draw the image. By specifying width and height, we force the stretch.
                        // ctx.drawImage(image, x, y, width, height)
                        ctx.drawImage(img, 0, 0, size, size);

                        // 3. Convert canvas back to a Blob/File
                        // '0.8' is the quality argument (0 to 1) for JPEG/WEBP
                        canvas.toBlob((blob) => {
                            if (!blob) {
                                reject(new Error('Canvas is empty'));
                                return;
                            }
                            // Create a new File object to mimic the original input
                            const resizedFile = new File([blob], file.name, {
                                type: 'image/jpeg', // Force JPEG or keep original type
                                lastModified: Date.now(),
                            });
                            resolve(resizedFile);
                        }, 'image/jpeg', 0.9); // Adjust quality here (0.9 = 90%)
                    };
                    img.onerror = (err) => reject(err);
                    img.src = event.target.result;
                };
                reader.onerror = (err) => reject(err);
                reader.readAsDataURL(file);
            });
        }

        async function previewMeme() {
            const imageInput = document.getElementById('imageInput');
            const topText = document.getElementById('topText').value;
            const bottomText = document.getElementById('bottomText').value;
            const title = document.getElementById('title').value;
            const body = document.getElementById('body').value;

            if (imageInput.files.length === 0) {
                alert("Please select an image first!");
                return;
            }

            if (!title) {
                alert("Please enter a title!");
                return;
            }

            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('preview-area').classList.add('hidden');

            try {
                // Compress image before sending
                const originalFile = imageInput.files[0];
                const compressedFile = await resize(originalFile);
                console.log(`Image compressed from ${originalFile.size}MB to ${compressedFile.size}MB`);

                const formData = new FormData();
                formData.append('image', compressedFile);
                formData.append('top', topText);
                formData.append('bottom', bottomText);

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout

                const response = await fetch('{{ route('posts.preview') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData,
                    signal: controller.signal
                });

                clearTimeout(timeoutId);

                if (!response.ok) {
                    throw new Error("Failed to generate meme");
                }

                const blob = await response.blob();
                const imageUrl = URL.createObjectURL(blob);

                // Convert blob to base64 for form submission
                const reader = new FileReader();
                reader.onloadend = function() {
                    document.getElementById('confirm-meme-data').value = reader.result;
                };
                reader.readAsDataURL(blob);

                document.getElementById('meme-preview').src = imageUrl;
                document.getElementById('confirm-title').value = title;
                document.getElementById('confirm-body').value = body;
                document.getElementById('confirm-top').value = topText;
                document.getElementById('confirm-bottom').value = bottomText;

                document.getElementById('loading').classList.add('hidden');
                document.getElementById('preview-area').classList.remove('hidden');

            } catch (error) {
                console.error(error);
                document.getElementById('loading').classList.add('hidden');

                if (error.name === 'AbortError') {
                    alert(
                        "Request timed out! The image file is too large or the server is taking too long to respond. Please try a smaller image (under 5MB recommended)."
                    );
                } else {
                    alert(
                        error
                    );
                }
            }
        }

        function resetForm() {
            document.getElementById('preview-area').classList.add('hidden');
            document.getElementById('memeForm').classList.remove('hidden');
        }
    </script>
</x-app-layout>
