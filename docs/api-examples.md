# 🌿 Chatla REST API Reference & Examples

This document provides a comprehensive reference of all endpoints exposed by the Chatla platform, complete with actual HTTP requests, query parameters, payload schemas, and real JSON responses.

---

## Base URL
```
http://localhost:8000/api
```

---

## 1. Botanical Search (`GET /api/plants/search`)
Search for plant species across all Moroccan nurseries by partial name or plant family name.

### Request
```http
GET /api/plants/search?name=Monstera HTTP/1.1
Host: localhost:8000
Accept: application/json
```

**cURL Example:**
```bash
curl -X GET "http://localhost:8000/api/plants/search?name=Monstera" \
  -H "Accept: application/json"
```

### Response (`200 OK`)
```json
{
  "success": true,
  "filters": {
    "name": "Monstera",
    "family": null
  },
  "plants": [
    {
      "id": 1,
      "name": "Monstera Deliciosa",
      "slug": "monstera-deliciosa",
      "family": {
        "id": 1,
        "name": "Araceae",
        "slug": "araceae"
      },
      "description": "The Monstera Deliciosa, commonly known as the Swiss Cheese Plant, is an icon of indoor gardening. Famous for its large, heart-shaped leaves that develop dramatic holes (fenestrations) as they mature, it brings an instant tropical vibe to any space. Native to the rainforests of Southern Mexico and Panama, it thrives in bright, indirect light and well-draining soil.",
      "light_need": "Bright, indirect sunlight",
      "watering": "Every 1-2 weeks",
      "temperature": "18°C - 30°C",
      "pet_friendly": false,
      "sun_exposure": "Avoid direct hot afternoon sun as it can burn the leaves. Filtered morning light is ideal.",
      "leaf_care": "Wipe leaves with a damp cloth every few weeks to keep them dust-free and shiny.",
      "support_instructions": "As a climber, it loves a moss pole to attach its aerial roots to for stability.",
      "images": [
        {
          "path": "default_plants/monstera_deliciosa_primary.jpg",
          "is_primary": true
        },
        {
          "path": "default_plants/monstera_deliciosa_2.jpg",
          "is_primary": false
        }
      ],
      "nurseries": [
        {
          "nursery_id": 1,
          "nursery_name": "Rozana Garden",
          "nursery_city": "Casablanca",
          "nursery_region": "Casablanca-Settat",
          "stock_status": "in_stock",
          "growth_status": "mature",
          "quantity": 12,
          "price": 140.0
        }
      ]
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 20,
    "total": 1,
    "last_page": 1
  }
}
```

---

## 2. Advanced Search by Growth Stage (`GET /api/plants/search/advanced`)
Filter botanical catalog by plant name and growth stage (`seed`, `seedling`, `vegetative`, `mature`).

### Request
```http
GET /api/plants/search/advanced?name=Monstera&growth=mature HTTP/1.1
Host: localhost:8000
Accept: application/json
```

**cURL Example:**
```bash
curl -X GET "http://localhost:8000/api/plants/search/advanced?name=Monstera&growth=mature" \
  -H "Accept: application/json"
```

### Response (`200 OK`)
```json
{
  "success": true,
  "filters": {
    "name": "Monstera",
    "growth": "mature"
  },
  "plants": [
    {
      "id": 1,
      "name": "Monstera Deliciosa",
      "slug": "monstera-deliciosa",
      "family": {
        "id": 1,
        "name": "Araceae",
        "slug": "araceae"
      },
      "growth_status": "mature",
      "nurseries": [
        {
          "nursery_id": 1,
          "nursery_name": "Rozana Garden",
          "growth_status": "mature",
          "quantity": 12,
          "price": 140.0
        }
      ]
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 20,
    "total": 1,
    "last_page": 1
  }
}
```

---

## 3. Location-Based Botanical Search (`GET /api/plants/search/location`)
Discover plant species that are actively stocked in nurseries within a specific city or region of Morocco.

### Request
```http
GET /api/plants/search/location?city=Casablanca HTTP/1.1
Host: localhost:8000
Accept: application/json
```

**cURL Example:**
```bash
curl -X GET "http://localhost:8000/api/plants/search/location?city=Casablanca" \
  -H "Accept: application/json"
```

### Response (`200 OK`)
```json
{
  "success": true,
  "filters": {
    "region": null,
    "city": "Casablanca"
  },
  "plants": [
    {
      "id": 1,
      "name": "Monstera Deliciosa",
      "slug": "monstera-deliciosa",
      "family": {
        "id": 1,
        "name": "Araceae",
        "slug": "araceae"
      },
      "nurseries": [
        {
          "nursery_id": 6,
          "nursery_name": "Bourgeons de Casablanca",
          "nursery_city": "Casablanca",
          "nursery_region": "Casablanca-Settat"
        }
      ]
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 20,
    "total": 1,
    "last_page": 1
  }
}
```

---

## 4. Single Plant Specification & Availability (`GET /api/plants/{id}`)
Fetches complete botanical care instructions, environmental requirements, and current stock across all registered Moroccan nurseries.

### Request
```http
GET /api/plants/1 HTTP/1.1
Host: localhost:8000
Accept: application/json
```

**cURL Example:**
```bash
curl -X GET "http://localhost:8000/api/plants/1" \
  -H "Accept: application/json"
```

### Response (`200 OK`)
```json
{
  "success": true,
  "plant": {
    "id": 1,
    "name": "Monstera Deliciosa",
    "slug": "monstera-deliciosa",
    "family": {
      "id": 1,
      "name": "Araceae",
      "slug": "araceae"
    },
    "description": "The Monstera Deliciosa, commonly known as the Swiss Cheese Plant, is an icon of indoor gardening. Famous for its large, heart-shaped leaves that develop dramatic holes (fenestrations) as they mature, it brings an instant tropical vibe to any space.",
    "light_need": "Bright, indirect sunlight",
    "watering": "Every 1-2 weeks",
    "temperature": "18°C - 30°C",
    "pet_friendly": false,
    "sun_exposure": "Avoid direct hot afternoon sun as it can burn the leaves. Filtered morning light is ideal.",
    "leaf_care": "Wipe leaves with a damp cloth every few weeks to keep them dust-free and shiny.",
    "support_instructions": "As a climber, it loves a moss pole to attach its aerial roots to for stability.",
    "images": [
      {
        "path": "default_plants/monstera_deliciosa_primary.jpg",
        "is_primary": true
      }
    ],
    "nurseries": [
      {
        "nursery_id": 1,
        "nursery_name": "Rozana Garden",
        "growth_status": "mature",
        "stock_status": "in_stock",
        "quantity": 12,
        "price": 140.0
      }
    ]
  }
}
```

---

## 5. Protected: Add Plant to Inventory (`POST /api/plants`)
Allows an authenticated Nursery Owner (`nursery_owner` role) to add a plant species with quantity, price, and growth stage to their nursery's live inventory.

### Headers & Auth
- Authentication: Session cookie or Sanctum token
- Role requirement: `nursery_owner`
- `Content-Type: application/json`
- `Accept: application/json`

### Request Body
```json
{
  "plant_id": 2,
  "growth_status": "seedling",
  "stock_status": "in_stock",
  "quantity": 15,
  "price": 65.50,
  "custom_desc": "Locally grown in Rozana Garden greenhouse, acclimated to Moroccan climate."
}
```

**cURL Example:**
```bash
curl -X POST "http://localhost:8000/api/plants" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "X-XSRF-TOKEN: <xsrf-token>" \
  -b "laravel-session=<session-cookie>" \
  -d '{
    "plant_id": 2,
    "growth_status": "seedling",
    "stock_status": "in_stock",
    "quantity": 15,
    "price": 65.50,
    "custom_desc": "Locally grown in Rozana Garden greenhouse, acclimated to Moroccan climate."
  }'
```

### Response (`201 Created`)
```json
{
  "success": true,
  "message": "Plant added to your nursery inventory successfully.",
  "inventory": {
    "id": 51,
    "nursery_id": 1,
    "plant_id": 2,
    "slug": "philodendron-imperial-green-at-rozana-garden-51",
    "growth_status": "seedling",
    "stock_status": "in_stock",
    "quantity": 15,
    "price": 65.5,
    "custom_description": "Locally grown in Rozana Garden greenhouse, acclimated to Moroccan climate.",
    "created_at": "2026-11-20T17:36:00.000000Z",
    "updated_at": "2026-11-20T17:36:00.000000Z",
    "plant": {
      "id": 2,
      "name": "Philodendron Imperial Green",
      "family": {
        "id": 1,
        "name": "Araceae"
      }
    },
    "images": []
  }
}
```

---

## 6. Protected: Remove Plant from Inventory (`DELETE /api/plants/{id}`)
Removes a plant entry from the authenticated nursery owner's stock. Requires the explicit `?confirm=1` query parameter as an operational safety guard.

### Request
```http
DELETE /api/plants/51?confirm=1 HTTP/1.1
Host: localhost:8000
Accept: application/json
```

**cURL Example:**
```bash
curl -X DELETE "http://localhost:8000/api/plants/51?confirm=1" \
  -H "Accept: application/json" \
  -H "X-XSRF-TOKEN: <xsrf-token>" \
  -b "laravel-session=<session-cookie>"
```

### Response (`200 OK`)
```json
{
  "success": true,
  "message": "Plant removed from your nursery inventory."
}
```

### Error Response (`400 Bad Request` without `?confirm=1`)
```json
{
  "success": false,
  "message": "Add ?confirm=1 to the request URL to confirm deletion."
}
```
