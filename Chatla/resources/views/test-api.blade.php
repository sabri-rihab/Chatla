<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatla🌱 API Tester</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00f260;
            --primary-dark: #0575E6;
            --bg-base: #0f172a;
            --bg-surface: rgba(30, 41, 59, 0.7);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            min-height: 100vh;
            background-image: 
                radial-gradient(at 0% 0%, rgba(0, 242, 96, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(5, 117, 230, 0.15) 0px, transparent 50%);
            background-attachment: fixed;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 3rem;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .panel {
            background: var(--bg-surface);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .panel-title {
            font-size: 1.5rem;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1rem;
            color: #fff;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        input, select {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border);
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(0, 242, 96, 0.2);
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        button {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 242, 96, 0.2);
        }

        button:active {
            transform: translateY(0);
        }

        .action-card {
            border: 1px solid var(--border);
            padding: 1.5rem;
            border-radius: 15px;
            background: rgba(15, 23, 42, 0.3);
            transition: border-color 0.3s;
        }

        .action-card:hover {
            border-color: rgba(255,255,255,0.3);
        }

        .action-card h3 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            color: #fff;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-right: 0.5rem;
            text-transform: uppercase;
        }

        .badge.get { background: rgba(5, 117, 230, 0.2); color: #60a5fa; border: 1px solid rgba(5, 117, 230, 0.4); }
        .badge.post { background: rgba(0, 242, 96, 0.2); color: #4ade80; border: 1px solid rgba(0, 242, 96, 0.4); }
        .badge.delete { background: rgba(244, 63, 94, 0.2); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.4); }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.5rem;
        }

        .tab {
            padding: 0.5rem 1rem;
            cursor: pointer;
            color: var(--text-muted);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .tab.active {
            color: var(--primary);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
        }

        .response-area {
            flex-grow: 1;
            background: #020617;
            border-radius: 10px;
            padding: 1.5rem;
            overflow-y: auto;
            border: 1px solid var(--border);
            font-family: monospace;
            font-size: 0.9rem;
            white-space: pre-wrap;
            max-height: 600px;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .status-200, .status-201 { background: #059669; color: white; }
        .status-400, .status-404, .status-422, .status-403, .status-401 { background: #e11d48; color: white; }
        .status-500 { background: #9f1239; color: white; }

        .loading {
            display: none;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--primary);
        }

        .spinner {
            border: 3px solid rgba(0, 242, 96, 0.1);
            border-radius: 50%;
            border-top: 3px solid var(--primary);
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 900px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Chatla🌱 API Interactor</h1>
        <p class="subtitle">Test, visualize, and debug your Plant & Nursery API endpoints.</p>
    </header>

    <div class="container">
        
        <!-- Controls Panel -->
        <div class="panel">
            <h2 class="panel-title">Requests</h2>
            
            <div class="tabs" id="api-tabs">
                <div class="tab active" data-target="search-plants">Search Plants</div>
                <div class="tab" data-target="crud-plants">CRUD Plants</div>
                <div class="tab" data-target="search-nurseries">Nurseries</div>
            </div>

            <!-- Search Plants View -->
            <div id="search-plants" class="tab-content" style="display: block;">
                <div class="action-card">
                    <h3><span class="badge get">GET</span> Basic Search</h3>
                    <form id="form-search-plants" onsubmit="event.preventDefault(); submitRequest('/api/plants/search', 'GET', this);">
                        <div class="row">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="e.g. Ficus">
                            </div>
                            <div class="form-group">
                                <label>Family</label>
                                <input type="text" name="family" placeholder="e.g. Moraceae">
                            </div>
                        </div>
                        <button type="submit" style="margin-top: 1rem; width: 100%;">Search Plants</button>
                    </form>
                </div>
                
                <div class="action-card" style="margin-top: 1rem;">
                    <h3><span class="badge get">GET</span> Advanced Search</h3>
                    <form id="form-adv-search-plants" onsubmit="event.preventDefault(); submitRequest('/api/plants/search/advanced', 'GET', this);">
                        <div class="row">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="e.g. Ficus">
                            </div>
                            <div class="form-group">
                                <label>Growth Status</label>
                                <select name="growth">
                                    <option value="">Any</option>
                                    <option value="seed">Seed</option>
                                    <option value="seedling">Seedling</option>
                                    <option value="vegetative">Vegetative</option>
                                    <option value="mature">Mature</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 0.5rem;">
                            <div class="form-group">
                                <label>Watering Frequency</label>
                                <input type="text" name="watering_frequency" placeholder="e.g. weekly">
                            </div>
                            <div class="form-group">
                                <label>Sunlight</label>
                                <input type="text" name="sunlight" placeholder="e.g. full sun">
                            </div>
                        </div>
                        <button type="submit" style="margin-top: 1rem; width: 100%;">Advanced Search</button>
                    </form>
                </div>
            </div>

            <!-- CRUD Plants View -->
            <div id="crud-plants" class="tab-content" style="display: none;">
                <div class="action-card">
                    <h3><span class="badge post">POST</span> Add Plant</h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">Requires Authentication & Nursery Owner Role</p>
                    <form id="form-add-plant" onsubmit="event.preventDefault(); submitRequest('/api/plants', 'POST', this, true);">
                        <div class="form-group" style="margin-bottom: 0.5rem;">
                            <label>Plant Species</label>
                            <select name="plant_id" required>
                                <option value="" disabled selected>Select a plant species from DB</option>
                                @foreach($plants as $plant)
                                    <option value="{{ $plant->id }}">{{ $plant->name }} ({{ $plant->family?->name ?? 'No Family' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label>Growth Status</label>
                                <select name="growth_status" required>
                                    <option value="seed">Seed</option>
                                    <option value="seedling">Seedling</option>
                                    <option value="vegetative">Vegetative</option>
                                    <option value="mature">Mature</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Stock Status</label>
                                <select name="stock_status">
                                    <option value="in_stock">In Stock</option>
                                    <option value="low_stock">Low Stock</option>
                                    <option value="pre_ordered">Pre-ordered</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 0.5rem;">
                            <div class="form-group">
                                <label>Price (DH)</label>
                                <input type="number" name="price" step="0.01" placeholder="150" min="0">
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity" required placeholder="10" min="0">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 0.5rem;">
                            <label>Custom Description (Optional)</label>
                            <input type="text" name="custom_desc" placeholder="Special care details for this inventory...">
                        </div>
                        <button type="submit" style="margin-top: 1rem; width: 100%;">Add to Inventory</button>
                    </form>
                </div>

                <div class="action-card" style="margin-top: 1rem;">
                    <h3><span class="badge delete">DELETE</span> Remove Plant</h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">Delete from inventory. Requires confirmation.</p>
                    <form id="form-delete-plant" onsubmit="event.preventDefault(); submitRequest('/api/plants/' + this.id.value + '?confirm=1', 'DELETE', null, true);">
                        <div class="form-group">
                            <label>Plant ID</label>
                            <input type="number" name="id" required placeholder="ID of plant to delete">
                        </div>
                        <button type="submit" style="margin-top: 1rem; width: 100%; background: linear-gradient(135deg, #f43f5e, #be123c);">Delete Plant</button>
                    </form>
                </div>
                
                <div class="action-card" style="margin-top: 1rem;">
                    <h3><span class="badge get">GET</span> Get Single Plant</h3>
                    <form id="form-get-plant" onsubmit="event.preventDefault(); submitRequest('/api/plants/' + this.id.value, 'GET');">
                        <div class="form-group">
                            <label>Plant ID</label>
                            <input type="number" name="id" required placeholder="ID of plant">
                        </div>
                        <button type="submit" style="margin-top: 1rem; width: 100%;">Fetch Details</button>
                    </form>
                </div>
            </div>

            <!-- Search Nurseries View -->
            <div id="search-nurseries" class="tab-content" style="display: none;">
                <div class="action-card">
                    <h3><span class="badge get">GET</span> Find Nurseries</h3>
                    <form id="form-search-nurseries" onsubmit="event.preventDefault(); submitRequest('/api/nurseries/search', 'GET', this);">
                        <div class="row">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="e.g. Green">
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" placeholder="e.g. Rabat">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 0.5rem;">
                            <label>Region</label>
                            <input type="text" name="region" placeholder="e.g. Rabat-Salé-Kénitra">
                        </div>
                        <button type="submit" style="margin-top: 1rem; width: 100%;">Search Nurseries</button>
                    </form>
                </div>
                
                <div class="action-card" style="margin-top: 1rem;">
                    <h3><span class="badge get">GET</span> Nursery Inventory</h3>
                    <form id="form-nursery-plants" onsubmit="event.preventDefault(); submitRequest('/api/nurseries/' + this.id.value + '/plants', 'GET');">
                        <div class="form-group">
                            <label>Nursery ID</label>
                            <input type="number" name="id" required placeholder="Enter Nursery ID">
                        </div>
                        <button type="submit" style="margin-top: 1rem; width: 100%;">View Plants</button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Output Panel -->
        <div class="panel">
            <h2 class="panel-title" style="display: flex; justify-content: space-between; align-items: center;">
                <span>Response</span>
                <span id="response-status" class="status-badge" style="display: none; margin: 0;"></span>
            </h2>
            
            <div id="loading" class="loading">
                <div class="spinner"></div>
                <span style="margin-left: 1rem; font-weight: 500;">Processing request...</span>
            </div>

            <div id="response-container" class="response-area">
                <div style="color: var(--text-muted); height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5;">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    Send a request to see the response payload here.
                </div>
            </div>
        </div>

    </div>

    <!-- Script for Handling Tabs and Requests -->
    <script>
        // Tab system
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.style.display = 'none');
                
                tab.classList.add('active');
                document.getElementById(tab.dataset.target).style.display = 'block';
            });
        });

        // Request Logic
        async function submitRequest(url, method, formElement = null, isJson = false) {
            const container = document.getElementById('response-container');
            const loading = document.getElementById('loading');
            const statusBadge = document.getElementById('response-status');
            
            container.style.display = 'none';
            statusBadge.style.display = 'none';
            loading.style.display = 'flex';

            let fetchUrl = url;
            let options = {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            };

            // Add CSRF token for stateful auth compatibility
            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
            if(csrfTokenElement) {
                options.headers['X-CSRF-TOKEN'] = csrfTokenElement.getAttribute('content');
            }

            if (formElement) {
                const formData = new FormData(formElement);
                
                if (method === 'GET') {
                    const params = new URLSearchParams();
                    for (let [key, value] of formData.entries()) {
                        if (value.trim() !== '') {
                            params.append(key, value);
                        }
                    }
                    const queryString = params.toString();
                    if (queryString) {
                        fetchUrl += (fetchUrl.includes('?') ? '&' : '?') + queryString;
                    }
                } else {
                    if (isJson) {
                        options.headers['Content-Type'] = 'application/json';
                        const jsonObject = {};
                        formData.forEach((value, key) => {
                            if(value !== '') jsonObject[key] = value;
                        });
                        options.body = JSON.stringify(jsonObject);
                    } else {
                        options.body = formData;
                    }
                }
            }

            try {
                const response = await fetch(fetchUrl, options);
                
                // Update Status Badge
                statusBadge.textContent = `${response.status} ${response.statusText}`;
                statusBadge.className = 'status-badge';
                statusBadge.classList.add(`status-${response.status >= 500 ? '500' : (response.status >= 400 ? '400' : '200')}`);
                statusBadge.style.display = 'inline-block';

                const responseText = await response.text();
                let displayData;
                
                try {
                    const jsonData = JSON.parse(responseText);
                    displayData = syntaxHighlight(JSON.stringify(jsonData, null, 4));
                } catch (e) {
                    displayData = escapeHtml(responseText);
                }

                container.innerHTML = displayData;
            } catch (error) {
                statusBadge.textContent = 'Error';
                statusBadge.className = 'status-badge status-500';
                statusBadge.style.display = 'inline-block';
                container.innerHTML = `<span style="color: #ef4444;">Request failed: ${error.message}</span>`;
            } finally {
                loading.style.display = 'none';
                container.style.display = 'block';
            }
        }

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Color coding for JSON
        function syntaxHighlight(json) {
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                let cls = 'number';
                let style = 'color: #38bdf8;'; // Default light blue for numbers
                
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                        style = 'color: #c084fc; font-weight: bold;'; // purple for keys
                    } else {
                        cls = 'string';
                        style = 'color: #a7f3d0;'; // light green for strings
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                    style = 'color: #fbbf24;'; // yellow for booleans
                } else if (/null/.test(match)) {
                    cls = 'null';
                    style = 'color: #f87171;'; // red for null
                }
                return '<span class="' + cls + '" style="' + style + '">' + match + '</span>';
            });
        }
    </script>
</body>
</html>
