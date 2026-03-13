<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - 8 March Party</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .panel {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .panel h2 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-box {
            flex: 1;
            min-width: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }

        .stat-label {
            font-size: 0.75rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            max-height: 400px;
            overflow-y: auto;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .photo-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .photo-item:hover {
            transform: scale(1.05);
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .suggestions-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .suggestion-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #667eea;
        }

        .suggestion-text {
            color: #333;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .suggestion-meta {
            font-size: 0.75rem;
            color: #999;
            display: flex;
            justify-content: space-between;
        }

        .empty {
            text-align: center;
            color: #999;
            padding: 2rem 1rem;
        }

        .empty-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .button-group {
            display: flex;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        button {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .status {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }

        .status.show {
            display: block;
        }

        .status.success {
            background: #d4edda;
            color: #155724;
        }

        .status.error {
            background: #f8d7da;
            color: #721c24;
        }

        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .lightbox.open {
            display: flex;
        }

        .lightbox img {
            max-width: 90vw;
            max-height: 90vh;
            border-radius: 8px;
        }

        .lightbox-close {
            position: absolute;
            top: 2rem;
            right: 2rem;
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🎉 Admin Panel</h1>
            <p class="subtitle">8 March Party - Real-time Data</p>
        </header>

        <div class="grid">
            <!-- Photos Panel -->
            <div class="panel">
                <h2>📸 Photos</h2>
                <div class="stats">
                    <div class="stat-box">
                        <span class="stat-number" id="photo-count">0</span>
                        <span class="stat-label">Photos</span>
                    </div>
                </div>
                <div id="status-photos" class="status"></div>
                <div class="photo-grid" id="photo-grid">
                    <div class="empty">
                        <span class="empty-icon">📷</span>
                        <p>No photos yet</p>
                    </div>
                </div>
                <div class="button-group">
                    <button class="btn-primary" onclick="loadPhotos()">🔄 Refresh</button>
                    <button class="btn-secondary" onclick="downloadPhotos()">⬇️ Export</button>
                </div>
            </div>

            <!-- Suggestions Panel -->
            <div class="panel">
                <h2>💌 Suggestions</h2>
                <div class="stats">
                    <div class="stat-box">
                        <span class="stat-number" id="suggestion-count">0</span>
                        <span class="stat-label">Wishes</span>
                    </div>
                </div>
                <div id="status-suggestions" class="status"></div>
                <div class="suggestions-list" id="suggestions-list">
                    <div class="empty">
                        <span class="empty-icon">💭</span>
                        <p>No suggestions yet</p>
                    </div>
                </div>
                <div class="button-group">
                    <button class="btn-primary" onclick="loadSuggestions()">🔄 Refresh</button>
                    <button class="btn-secondary" onclick="downloadSuggestions()">⬇️ Export</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
        <button class="lightbox-close" onclick="closeLightbox()">✕</button>
        <img id="lightbox-img" src="" alt="">
    </div>

    <script>
        const API_PHOTOS = './api_photos.php';
        const API_SUGGESTIONS = './api_suggestions.php';

        async function loadPhotos() {
            try {
                const resp = await fetch(API_PHOTOS);
                const result = await resp.json();
                const photos = result.data || [];

                document.getElementById('photo-count').textContent = photos.length;
                const grid = document.getElementById('photo-grid');

                if (photos.length === 0) {
                    grid.innerHTML = '<div class="empty"><span class="empty-icon">📷</span><p>No photos yet</p></div>';
                    return;
                }

                grid.innerHTML = photos.reverse().map((photo, i) => {
                    const src = photo.image_data || photo.src;
                    return `
                        <div class="photo-item" onclick="openLightbox('${src.replace(/'/g, "\\'")}')">
                            <img src="${src}" alt="Photo ${i + 1}">
                        </div>
                    `;
                }).join('');

                showStatus('photos', 'Loaded ' + photos.length + ' photos', 'success');
            } catch(e) {
                showStatus('photos', 'Error loading photos: ' + e.message, 'error');
            }
        }

        async function loadSuggestions() {
            try {
                const resp = await fetch(API_SUGGESTIONS);
                const result = await resp.json();
                const suggestions = result.data || [];

                document.getElementById('suggestion-count').textContent = suggestions.length;
                const list = document.getElementById('suggestions-list');

                if (suggestions.length === 0) {
                    list.innerHTML = '<div class="empty"><span class="empty-icon">💭</span><p>No suggestions yet</p></div>';
                    return;
                }

                list.innerHTML = suggestions.reverse().map((s, i) => {
                    const text = s.text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    const time = s.time_display || s.time || 'Unknown';
                    const date = s.date_display || s.date || '';
                    return `
                        <div class="suggestion-item">
                            <div class="suggestion-text">${text}</div>
                            <div class="suggestion-meta">
                                <span>👤 Anonymous</span>
                                <span>${time} · ${date}</span>
                            </div>
                        </div>
                    `;
                }).join('');

                showStatus('suggestions', 'Loaded ' + suggestions.length + ' suggestions', 'success');
            } catch(e) {
                showStatus('suggestions', 'Error loading suggestions: ' + e.message, 'error');
            }
        }

        function showStatus(type, message, status) {
            const el = document.getElementById('status-' + type);
            el.textContent = message;
            el.className = 'status show ' + status;
            setTimeout(() => el.classList.remove('show'), 3000);
        }

        function openLightbox(src) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox').classList.add('open');
        }

        function closeLightbox(e) {
            if (e && e.target !== e.currentTarget) return;
            document.getElementById('lightbox').classList.remove('open');
        }

        function downloadPhotos() {
            const text = 'Photos can be downloaded individually by clicking on them in the lightbox.';
            alert(text);
        }

        function downloadSuggestions() {
            const text = document.getElementById('suggestions-list').innerText;
            const element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', 'suggestions.txt');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }

        // Load on startup and auto-refresh every 5 seconds
        loadPhotos();
        loadSuggestions();

        setInterval(() => {
            loadPhotos();
            loadSuggestions();
        }, 5000);
    </script>
</body>
</html>
