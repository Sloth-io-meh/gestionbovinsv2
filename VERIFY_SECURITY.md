# 🧪 Security Headers Verification Guide

This guide shows you how to verify that all security headers are properly configured.

## Quick Test (2 minutes)

### Step 1: Start the Application

**Using Docker (Recommended):**
```powershell
cd c:\Users\ULTRAPC\Documents\GitHub\gestionbovins-secure
docker-compose up -d
# Wait 10 seconds for services to start
```

**Using Laravel Artisan:**
```powershell
cd c:\Users\ULTRAPC\Documents\GitHub\gestionbovins-secure
php artisan serve
# Access at http://localhost:8000
```

### Step 2: Check Security Headers

**Option A: cURL Command**
```bash
curl -I http://localhost:8000
```

**Expected Output:**
```
HTTP/1.1 200 OK
Server: nginx
Content-Type: text/html; charset=UTF-8
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'...
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=()...
X-XSS-Protection: 1; mode=block
```

**Option B: Browser DevTools**
1. Open http://localhost:8000
2. Press `F12` (or right-click → Inspect)
3. Go to **Network** tab
4. Refresh page
5. Click on the first request (document)
6. Scroll down in **Response Headers** section
7. Verify all 6 security headers are present

**Option C: Browser Console**
```javascript
// Open browser DevTools (F12) → Console
// Paste this to see security headers:
fetch('http://localhost:8000').then(r => {
  console.log('Strict-Transport-Security:', r.headers.get('Strict-Transport-Security'));
  console.log('Content-Security-Policy:', r.headers.get('Content-Security-Policy'));
  console.log('X-Frame-Options:', r.headers.get('X-Frame-Options'));
  console.log('X-Content-Type-Options:', r.headers.get('X-Content-Type-Options'));
  console.log('Referrer-Policy:', r.headers.get('Referrer-Policy'));
  console.log('Permissions-Policy:', r.headers.get('Permissions-Policy'));
})
```

---

## Detailed Verification Checklist

### ✅ Header 1: Strict-Transport-Security (HSTS)

**Purpose**: Force HTTPS only, prevent downgrade attacks

**Check**:
```bash
curl -I http://localhost:8000 | grep -i "Strict-Transport-Security"
```

**Expected**: 
```
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
```

**What it means**:
- `max-age=31536000` = Force HTTPS for 1 year (31,536,000 seconds)
- `includeSubDomains` = Apply to all subdomains
- `preload` = Include in browser's HSTS preload list

---

### ✅ Header 2: Content-Security-Policy (CSP)

**Purpose**: Prevent XSS attacks by restricting resource loading

**Check**:
```bash
curl -I http://localhost:8000 | grep -i "Content-Security-Policy"
```

**Expected** (similar to):
```
Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'...
```

**What it means**:
- `default-src 'self'` = Only allow resources from same origin
- `script-src 'self'` = Scripts only from same origin
- `style-src 'self'` = Stylesheets only from same origin
- Prevents inline scripts (XSS attacks)

---

### ✅ Header 3: X-Frame-Options

**Purpose**: Prevent clickjacking attacks

**Check**:
```bash
curl -I http://localhost:8000 | grep -i "X-Frame-Options"
```

**Expected**:
```
X-Frame-Options: DENY
```

**What it means**:
- `DENY` = Cannot be framed/embedded in iframes
- Prevents attackers from embedding your site in malicious pages

---

### ✅ Header 4: X-Content-Type-Options

**Purpose**: Prevent MIME type sniffing attacks

**Check**:
```bash
curl -I http://localhost:8000 | grep -i "X-Content-Type-Options"
```

**Expected**:
```
X-Content-Type-Options: nosniff
```

**What it means**:
- `nosniff` = Browser must not guess file types
- Prevents attackers from executing malicious files

---

### ✅ Header 5: Referrer-Policy

**Purpose**: Control what referrer info is shared

**Check**:
```bash
curl -I http://localhost:8000 | grep -i "Referrer-Policy"
```

**Expected**:
```
Referrer-Policy: strict-origin-when-cross-origin
```

**What it means**:
- Only send referrer for same-origin requests
- Protects user privacy

---

### ✅ Header 6: Permissions-Policy

**Purpose**: Disable dangerous browser features

**Check**:
```bash
curl -I http://localhost:8000 | grep -i "Permissions-Policy"
```

**Expected**:
```
Permissions-Policy: camera=(), microphone=(), geolocation=(), ...
```

**What it means**:
- Disables: Camera, Microphone, Geolocation, Payment APIs, etc.
- Even if user grants permission, features are blocked

---

### ✅ Header 7: X-Powered-By Removed

**Purpose**: Don't leak PHP version to attackers

**Check**:
```bash
curl -I http://localhost:8000 | grep -i "X-Powered-By"
```

**Expected**: 
```
(No output = header successfully removed ✓)
```

**What it means**:
- Original project leaked: `X-Powered-By: PHP/8.2.20`
- Attackers use this to target specific PHP vulnerabilities
- ✅ Now removed!

---

## Online Security Scanner

Test your application at these free online scanners:

### 1. **SecurityHeaders.io**
- URL: https://securityheaders.com
- Scan: http://localhost:8000 (if accessible externally)
- Expected: A+ grade (90+ score)

### 2. **Mozilla HTTP Observatory**
- URL: https://observatory.mozilla.org
- Scan: http://localhost:8000 (if accessible externally)
- Expected: A grade (80+ score)

### 3. **SSL Labs (when HTTPS ready)**
- URL: https://www.ssllabs.com/ssltest/
- For production HTTPS URL
- Expected: A or A+ grade

---

## Advanced Checks

### Check 1: Verify Middleware is Loading

```bash
# SSH into Docker container or run locally
php artisan tinker

# Check middleware
>>> app(\App\Http\Middleware\SecurityHeaders::class)
=> App\Http\Middleware\SecurityHeaders {#...}
```

### Check 2: Test CSRF Protection

Open browser console:
```javascript
// CSRF token should be present
document.querySelector('meta[name="csrf-token"]')
// Should return: <meta name="csrf-token" content="...">
```

### Check 3: Verify Session Cookies

Open browser DevTools → Application → Cookies
```
Session Cookie:
  Name: XSRF-TOKEN or Laravel session
  Domain: localhost
  Path: /
  Secure: ✓ (if HTTPS)
  HttpOnly: ✓
  SameSite: Strict
```

### Check 4: Database Connection

```bash
php artisan tinker
>>> DB::connection()->getPdo()
=> PDOConnection {...}  # Success!
```

---

## Troubleshooting

### Headers not appearing?

1. **Check middleware is registered:**
   ```bash
   php artisan route:list
   # Should show middleware
   ```

2. **Restart server:**
   ```bash
   # If using Docker:
   docker-compose restart app
   
   # If using artisan serve:
   # Stop (Ctrl+C) and restart
   php artisan serve
   ```

3. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Docker not starting?

```bash
# Check logs
docker-compose logs app

# Rebuild
docker-compose down
docker-compose up -d --build

# Verify services
docker-compose ps
```

### Port already in use?

```bash
# Change port in docker-compose.yml
# Change "8000:80" to "8001:80"

docker-compose down
docker-compose up -d
# Access at http://localhost:8001
```

---

## What to Report

When complete, verify these metrics:

- [ ] All 6 security headers present
- [ ] X-Powered-By header removed
- [ ] Session cookies marked HttpOnly
- [ ] Session cookies marked Secure
- [ ] Session cookies marked SameSite=Strict
- [ ] CSRF token present in HTML
- [ ] Database connection working
- [ ] Docker services running (if using Docker)

---

## Expected Results After Verification

```
✅ SecurityHeaders.io: A+ (95+/100)
✅ Mozilla HTTP Observatory: A (80+/100)  
✅ OWASP ZAP: CSP headers prevent XSS
✅ Browser: All 7 security headers visible
✅ Database: Connected and responsive
✅ Sessions: Secure cookies configured
```

---

**Generated**: May 16, 2026 | **Framework**: Laravel 12
