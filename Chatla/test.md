# Testing

 `http://localhost:8000`

---

## 🌿 Public Endpoints

You do not need to be authenticated to access these endpoints. You can test `GET` requests directly in your browser.

### 1. Basic Plant Search
Search for plants by partial name and/or plant family.
* **Method:** `GET`
* **URL:** `/api/plants/search?name=Ficus&family=Moraceae`
* **Note:** At least `name` or `family` must be provided.

### 2. Advanced Plant Search
Search for plants by name and/or their growth status.
* **Method:** `GET`
* **URL:** `/api/plants/search/advanced?name=Monstera&growth=seedling`
* **Note:** Valid `growth` values are `seed`, `seedling`, `vegetative`, `mature`.

### 3. Location-based Plant Search
Find plants available in specific regions or cities.
* **Method:** `GET`
* **URL:** `/api/plants/search/location?city=Casablanca&region=Casablanca-Settat`
* **Note:** At least `region` or `city` is required.

### 4. Fetch Single Plant
View the full details of a specific plant along with exactly which nurseries have it in stock.
* **Method:** `GET`
* **URL:** `/api/plants/1`
* **Note:** Replace `1` with a valid `plant_id`.

### 5. Search Nurseries
Search the directory of active nurseries by city, region, or partial name.
* **Method:** `GET`
* **URL:** `/api/nurseries/search?city=Rabat&name=Green`

### 6. Fetch Single Nursery Details
View the details of a specific nursery.
* **Method:** `GET`
* **URL:** `/api/nurseries/1`
* **Note:** Replace `1` with a valid `nursery_id`.

### 7. View Nursery Inventory
Browse the paginated catalog of plants available at a single nursery.
* **Method:** `GET`
* **URL:** `/api/nurseries/1/plants?per_page=15`
* **Note:** Replace `1` with a valid `nursery_id`.

---

## 🔒 Authentication

Before using protected API endpoints, you need to log in to establish a session.

### 8. Login (Authentication)
Authenticate a user to establish a Sanctum session. This is required for protected endpoints if you are not using API tokens.
* **Method:** `POST`
* **URL:** `/login`
* **Headers:** `Accept: application/json`, `Content-Type: application/json`
* **Payload Example (JSON):**
```json
{
  "email": "youssef.mansouri@chatla.ma",
  "password": "password"
}
```
* **Note:** When using Sanctum with SPA/Postman (cookie-based), you should first make a `GET` request to `/sanctum/csrf-cookie` to initialize CSRF protection before sending the `POST` request.

---

## 🔒 Protected Endpoints (Nursery Owners Only)

To test these endpoints, you **must be authenticated** as a user with the `nursery_owner` role and have a nursery registered to your account. 

If testing from Postman, ensure you either:
1. Log in via your web application (or via the **Login** endpoint above) first and ensure the CSRF/Session cookies are sent.
2. Obtain an API Token and attach it via the `Authorization: Bearer <token>` header.
3. Don't forget `Accept: application/json` in your headers.

### 9. Add Plant to Inventory
Add an existing plant to your nursery's stock.
* **Method:** `POST`
* **URL:** `/api/plants`
* **Headers:** `Accept: application/json`, `Content-Type: multipart/form-data` (if uploading files), or `Content-Type: application/json`
* **Payload Example (JSON):**
```json
{
  "plant_id": 1,
  "growth_status": "seedling",
  "stock_status": "in_stock",
  "quantity": 10,
  "price": 50.00,
  "custom_desc": "Locally grown, lots of care given."
}
```
*(Valid `growth_status`: `seed`, `seedling`, `vegetative`, `mature`)*
*(Valid `stock_status`: `in_stock`, `low_stock`, `pre_ordered`)*

### 10. Delete Plant from Inventory
Remove an inventory entry from your nursery.
* **Method:** `DELETE`
* **URL:** `/api/plants/5?confirm=1`
* **Note:**
  * Replace `5` with the **Inventory Entry ID** (from the `nursery_inventories` table), not the Plant ID. 
  * The `?confirm=1` query parameter is **required** as a safety gate.
